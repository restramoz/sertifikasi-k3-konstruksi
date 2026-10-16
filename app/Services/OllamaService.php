<?php

namespace App\Services;

use App\Models\Article;
use App\Support\WhatsApp;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OllamaService
{
    protected ?string $apiKey;

    protected ?string $baseUrl;

    protected ?string $model;

    protected int $timeout;

    /**
     * Standard Sertifikasi & Pelatihan K3 Konstruksi core topics.
     *
     * @var array<int, array{name: string, focus: string}>
     */
    public const CORE_TOPICS = [
        [
            'name' => 'Penerapan Sistem Manajemen Keselamatan Konstruksi (SMKK) Berdasarkan Permen PUPR No. 10/2021',
            'focus' => 'Penyusunan Rencana Keselamatan Konstruksi (RKK), identifikasi bahaya, dan audit SMK3 proyek',
        ],
        [
            'name' => 'Peran dan Tanggung Jawab Ahli K3 Konstruksi Muda di Proyek Lapangan',
            'focus' => 'Pengawasan operasional harian, safety briefing, inspeksi APD, dan kepatuhan prosedur kerja aman',
        ],
        [
            'name' => 'Koordinasi Manajemen Risiko dan Job Safety Analysis (JSA) oleh K3 Konstruksi Madya',
            'focus' => 'Mitigasi risiko pekerjaan berisiko tinggi, pengawasan site manager, dan evaluasi pengendalian insiden',
        ],
        [
            'name' => 'Manajemen Keselamatan Bekerja di Ketinggian dan Pemasangan Scaffolding Standar',
            'focus' => 'Pemeriksaan integritas perancah, penggunaan full body harness, anchor point, dan proteksi bahaya jatuh',
        ],
        [
            'name' => 'Keselamatan Operasi Alat Berat, Pengangkatan (Lifting) dan Rigging pada Proyek Gedung',
            'focus' => 'Surat Izin Laik Operasi (SILO), Surat Izin Operator (SIO), radius aman crane, dan inspeksi sling',
        ],
        [
            'name' => 'Strategi Manajemen K3 Konstruksi Utama untuk Direksi dan Pimpinan BUJK',
            'focus' => 'Kepemimpinan keselamatan kerja, alokasi anggaran biaya SMKK dalam dokumen tender, dan zero accident policy',
        ],
    ];

    public function __construct()
    {
        $this->apiKey = config('services.ollama.key');
        $this->baseUrl = config('services.ollama.base_url');
        $this->model = config('services.ollama.model');
        $this->timeout = (int) config('services.ollama.timeout', 120);
    }

    /**
     * Resolve chat endpoint URL safely.
     */
    public function getChatEndpoint(): string
    {
        $base = rtrim((string) $this->baseUrl, '/');

        if (str_ends_with($base, '/api/chat')) {
            return $base;
        }

        return "{$base}/api/chat";
    }

    /**
     * Select a relevant topic automatically based on region and existing articles.
     *
     * @return array{topic: string, focus: string}
     */
    public function pickTopicForRegion(string $cityName, ?string $citySlug = null): array
    {
        $existingTitles = [];
        if ($citySlug) {
            $existingTitles = Article::where('target_city_slug', $citySlug)
                ->pluck('title')
                ->toArray();
        }

        // Find first unused core topic
        foreach (self::CORE_TOPICS as $core) {
            $isUsed = false;
            foreach ($existingTitles as $title) {
                if (stripos($title, $core['name']) !== false) {
                    $isUsed = true;
                    break;
                }
            }

            if (! $isUsed) {
                return [
                    'topic' => "Panduan {$core['name']} untuk Proyek di {$cityName}",
                    'focus' => $core['focus'],
                ];
            }
        }

        // If all core topics are covered, return an advanced operational angle
        $count = count($existingTitles) + 1;

        return [
            'topic' => "Strategi Pengawasan K3 Konstruksi Lanjutan pada Proyek Infrastruktur di {$cityName} (Bagian {$count})",
            'focus' => 'Evaluasi kepatuhan SMKK, pembinaan kompetensi teknis pekerja, dan audit kesiapan operasional lapangan',
        ];
    }

    /**
     * Resolve word count from direct input (already validated as integer 300-3000).
     */
    public function resolveWordCount(int $wordCount): int
    {
        return $wordCount;
    }

    /**
     * Generate an article draft via Ollama.
     *
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>
     */
    public function generateArticle(array $params): array
    {
        // 1. Verifikasi kelengkapan konfigurasi tanpa memanggil API
        if (empty($this->baseUrl)) {
            return [
                'success' => false,
                'error' => 'Konfigurasi OLLAMA_BASE_URL belum diatur di file .env.',
            ];
        }

        if (empty($this->model)) {
            return [
                'success' => false,
                'error' => 'Konfigurasi OLLAMA_MODEL belum diatur di file .env.',
            ];
        }

        $cityName = trim((string) ($params['city_name'] ?? 'Indonesia'));
        $districtName = ! empty($params['district_name']) ? trim((string) $params['district_name']) : null;
        $citySlug = $params['city_slug'] ?? null;
        $wordCount = $this->resolveWordCount($params['word_count'] ?? 1000);

        // Auto topic selection if not manually provided
        if (empty($params['topic'])) {
            $selected = $this->pickTopicForRegion($cityName, $citySlug);
            $topic = $selected['topic'];
            $focus = $selected['focus'];
        } else {
            $topic = trim((string) $params['topic']);
            $focus = $params['focus'] ?? 'Pelatihan dan pembinaan keselamatan dan kesehatan kerja (K3) sektor konstruksi';
        }

        $locationContext = $districtName ? "Kecamatan {$districtName}, {$cityName}" : $cityName;

        $systemPrompt = <<<PROMPT
Anda adalah Lead Specialist Keselamatan & Kesehatan Kerja (K3) Konstruksi dan Konsultan Senior Sistem Manajemen Keselamatan Konstruksi (SMKK) di Indonesia.
Tugas Anda adalah menulis artikel edukatif dan otoritatif berstandar industri B2B dalam Bahasa Indonesia formal mengenai Sertifikasi dan Pelatihan K3 Konstruksi (jenjang Muda, Madya, Utama).

ATURAN KUALITAS & GAYA PENULISAN:
1. Nada bahasa: Profesional, lugas, mengalir alami, berbobot untuk pengambil keputusan konstruksi (Project Director, Site Manager, HSE Manager, Kontraktor/BUJK).
2. Dilarang menggunakan filler AI klise seperti "Di era modern saat ini", "Tak dapat dipungkiri", atau kalimat berulang.
3. Rujuk regulasi nyata Indonesia: UU No. 2 Tahun 2017 tentang Jasa Konstruksi, Permen PUPR No. 10 Tahun 2021 tentang Pedoman Sistem Manajemen Keselamatan Konstruksi (SMKK), UU No. 1 Tahun 1970 tentang Keselamatan Kerja, dan standar kompetensi kerja keselamatan konstruksi nasional.
4. Jangan mengarang jadwal tetap, biaya fiktif, alamat kantor palsu, atau klaim akreditasi sepihak. Arahkan konsultasi resmi melalui WhatsApp.
5. Gunakan tag HTML semantik: <h2>, <h3>, <p>, <ul>, <ol>, <li>, <strong>, <blockquote>, <table><thead><tr><th>...</th></tr></thead><tbody><tr><td>...</td></tr></tbody></table>.
6. Panjang target: Sekitar {$wordCount} kata.
7. Buat image_brief terpisah yang siap digunakan oleh desainer di Google Flow untuk menghasilkan gambar fotografi realistis beresolusi tinggi TANPA teks di gambar.

OUTPUT WAJIB:
Kembalikan HANYA dokumen JSON murni tanpa pembungkus markdown ```json ```.
Format skema JSON yang wajib dipatuhi:
{
  "title": "Judul Artikel Informatif dan Otoritatif",
  "slug": "slug-url-ramah-seo",
  "excerpt": "Ringkasan eksekutif 2-3 kalimat mengenai intisari artikel.",
  "content": "<p>Isi artikel lengkap dalam HTML semantik...</p>",
  "seo_title": "SEO Title Max 60 Karakter | Sertifikasi K3 Konstruksi",
  "meta_description": "Meta description persuasif max 155 karakter.",
  "suggested_faqs": [
    {"q": "Pertanyaan 1...", "a": "Jawaban ringkas 1..."},
    {"q": "Pertanyaan 2...", "a": "Jawaban ringkas 2..."}
  ],
  "image_brief": {
    "concept": "Konsep visual foto dalam Bahasa Indonesia",
    "english_prompt": "Detailed descriptive photo prompt in English for Google Flow: realistic photography, construction site in Indonesia, civil engineering project, workers wearing certified PPE and hardhats, realistic lighting, high detail, no text overlays, 8k",
    "aspect_ratio": "16:9",
    "recommended_alt": "Alt text ramah SEO dalam Bahasa Indonesia"
  }
}
PROMPT;

        $userPrompt = <<<PROMPT
Silakan buat artikel K3 Konstruksi lengkap dengan rincian berikut:
- Topik Artikel: {$topic}
- Fokus Materi: {$focus}
- Lokasi Target: {$locationContext}
- Target Jumlah Kata: ~{$wordCount} kata (perkiraan)

Keluarkan HANYA JSON valid.
PROMPT;

        try {
            $endpoint = $this->getChatEndpoint();
            $client = Http::timeout($this->timeout);

            if (! empty($this->apiKey)) {
                $client = $client->withToken($this->apiKey);
            }

            $response = $client->post($endpoint, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'stream' => false,
            ]);

            if (! $response->successful()) {
                Log::error('Ollama API error response', [
                    'status' => $response->status(),
                    'endpoint' => $endpoint,
                    'model' => $this->model,
                ]);

                return [
                    'success' => false,
                    'error' => "Ollama merespons dengan status HTTP {$response->status()}: ".Str::limit($response->body(), 200),
                ];
            }

            $data = $response->json();
            $rawContent = $data['message']['content'] ?? '';

            if (empty(trim($rawContent))) {
                return [
                    'success' => false,
                    'error' => 'Ollama mengembalikan respons konten kosong.',
                ];
            }

        $result = $this->parseResponse($rawContent, $topic, $cityName, $wordCount);

        // ---------------------------------------------------------------------
        // Enforce word‑count constraints before adding UI elements. Callouts
        // must not influence the word‑count validation.
        // ---------------------------------------------------------------------
        $generatedWordCount = $this->countWords($result['content'] ?? '');
        if ($generatedWordCount > 7000) {
            return [
                'success' => false,
                'error' => 'Generated article exceeds the maximum allowed 7.000 words.',
            ];
        }

        // Attempt continuation if the article is shorter than requested.
        $maxAttempts = 8; // Bounded continuation rounds to complete the target.
        $attempt = 0;
        while ($generatedWordCount < $wordCount && $attempt < $maxAttempts) {
            $remaining = $wordCount - $generatedWordCount;
            // Request continuation using the already generated raw content.
            $continuation = $this->requestContinuation($result['content'], $remaining, $cityName);
            if (! $continuation['success']) {
                // Propagate continuation failure.
                return $continuation;
            }
            // Append new content.
            $result['content'] .= $continuation['content'];
            $generatedWordCount = $this->countWords($result['content']);
            $attempt++;
        }

        if ($generatedWordCount < $wordCount) {
            return [
                'success' => false,
                'error' => 'Generated article is shorter than the requested word count.',
            ];
        }

        // After validation, inject five WhatsApp callouts.
        $result = $this->addWhatsAppCallout($result, $cityName);

        return $result;
        } catch (ConnectionException $e) {
            Log::error('Ollama connection timeout or unreachable: '.$e->getMessage());

            return [
                'success' => false,
                'error' => 'Koneksi ke Ollama gagal atau timeout setelah '.$this->timeout.' detik. Pastikan layanan Ollama aktif dan endpoint dapat dijangkau.',
            ];
        } catch (\Throwable $e) {
            Log::error('OllamaService Exception: '.$e->getMessage());

            return [
                'success' => false,
                'error' => 'Terjadi kesalahan saat memproses permintaan artikel: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Robust JSON parsing and fallback structure.
     *
     * @return array<string, mixed>
     */
    public function parseResponse(string $rawContent, string $fallbackTopic, string $cityName, int $wordCount): array
    {
        $cleaned = trim($rawContent);

        // Strip markdown code fences if present
        if (preg_match('/^```(?:json)?\s*(.*?)\s*```$/s', $cleaned, $matches)) {
            $cleaned = trim($matches[1]);
        } elseif (str_starts_with($cleaned, '```json')) {
            $cleaned = trim(substr($cleaned, 7));
            if (str_ends_with($cleaned, '```')) {
                $cleaned = trim(substr($cleaned, 0, -3));
            }
        } elseif (str_starts_with($cleaned, '```')) {
            $cleaned = trim(substr($cleaned, 3));
            if (str_ends_with($cleaned, '```')) {
                $cleaned = trim(substr($cleaned, 0, -3));
            }
        }

        $decoded = json_decode($cleaned, true);

        // If direct parse failed, attempt to extract JSON object with regex
        if (! is_array($decoded)) {
            if (preg_match('/\{[\s\S]*\}/', $cleaned, $extracted)) {
                $decoded = json_decode($extracted[0], true);
            }
        }

        if (is_array($decoded) && ! empty($decoded['title'])) {
            $imageBrief = $decoded['image_brief'] ?? [];
            if (! is_array($imageBrief)) {
                $imageBrief = [];
            }

            $concept = $imageBrief['concept'] ?? "Penerapan keselamatan konstruksi di area proyek {$cityName}";
            $englishPrompt = $imageBrief['english_prompt'] ?? 'Professional documentary photograph of construction site in Indonesia, civil engineers wearing safety vests and hardhats discussing safety blueprint, authentic industrial environment, realistic lighting, 8k, no text';
            $aspectRatio = $imageBrief['aspect_ratio'] ?? '16:9';
            $recommendedAlt = $imageBrief['recommended_alt'] ?? "Pelatihan K3 Konstruksi di {$cityName}";

            return [
                'success' => true,
                'title' => (string) $decoded['title'],
                'slug' => ! empty($decoded['slug']) ? Str::slug($decoded['slug']) : Str::slug($decoded['title']),
                'excerpt' => (string) ($decoded['excerpt'] ?? Str::limit(strip_tags($decoded['content'] ?? ''), 180)),
                'content' => (string) ($decoded['content'] ?? ''),
                'seo_title' => (string) ($decoded['seo_title'] ?? Str::limit($decoded['title'].' | Sertifikasi K3 Konstruksi', 60)),
                'meta_description' => (string) ($decoded['meta_description'] ?? Str::limit($decoded['excerpt'] ?? '', 155)),
                'suggested_faqs' => is_array($decoded['suggested_faqs'] ?? null) ? $decoded['suggested_faqs'] : [],
                'image_brief' => [
                    'concept' => $concept,
                    'english_prompt' => $englishPrompt,
                    'aspect_ratio' => $aspectRatio,
                    'recommended_alt' => $recommendedAlt,
                ],
            ];
        }

        // Recover HTML content when the model returns imperfect JSON.
        $fallbackContent = $cleaned;

        if (preg_match('/"content"\s*:\s*("(?:\\\\.|[^"\\\\])*")/s', $cleaned, $match)) {
            $extracted = json_decode($match[1], true);
            if (is_string($extracted) && trim($extracted) !== '') {
                $fallbackContent = $extracted;
            }
        }

        if (preg_match('/<\s*(p|h[1-6]|table|thead|tbody|tr|td|th|ul|ol|li|blockquote)\b/i', $fallbackContent)) {
            $fallbackHtml = $fallbackContent;
        } else {
            $fallbackHtml = '<p>'.nl2br(e($fallbackContent)).'</p>';
        }

        return [
            'success' => true,
            'title' => $fallbackTopic,
            'slug' => Str::slug($fallbackTopic),
            'excerpt' => Str::limit(strip_tags($fallbackHtml), 180),
            'content' => $fallbackHtml,
            'seo_title' => Str::limit("{$fallbackTopic} | Sertifikasi K3 Konstruksi", 60),
            'meta_description' => Str::limit("Panduan {$fallbackTopic} untuk kepatuhan SMKK dan standar keselamatan konstruksi di {$cityName}.", 155),
            'suggested_faqs' => [],
            'image_brief' => [
                'concept' => "Pengawasan keselamatan kerja konstruksi di {$cityName}",
                'english_prompt' => 'Professional photograph of a construction safety briefing in Indonesia, realistic lighting, no text',
                'aspect_ratio' => '16:9',
                'recommended_alt' => "Sertifikasi K3 Konstruksi - {$fallbackTopic}",
            ],
        ];
    }

    /**
     * Add context-aware WhatsApp CTA callouts without leaking hardcoded numbers.
     *
     * @param  array<string, mixed>  $result
     * @return array<string, mixed>
     */
    protected function addWhatsAppCallout(array $result, string $cityName): array
    {
        $content = $this->sanitizeContent($result['content'] ?? '');

        // Retrieve configured contacts; fallback to empty array.
        $contacts = config('services.whatsapp.callout_contacts', []);
        // Ensure we have at least one contact to avoid empty URLs.
        if (empty($contacts)) {
            return $result; // silently skip if no contacts configured.
        }

        // Prepare five contacts, allowing one repeat because we have four numbers.
        $shuffled = $contacts;
        shuffle($shuffled);
        // Take first four, then append a random one for the fifth.
        $selected = array_slice($shuffled, 0, 4);
        $selected[] = $shuffled[array_rand($shuffled)];

        // Split content by closing paragraph tags to insert between sections.
        $paragraphEnds = [];
        $offset = 0;
        while (($pos = strpos($content, '</p>', $offset)) !== false) {
            $paragraphEnds[] = $pos + 4; // position after </p>
            $offset = $pos + 4;
        }

        // Determine insertion indices – distribute roughly evenly.
        $insertPoints = [];
        $countEnds = count($paragraphEnds);
        for ($i = 0; $i < 5; $i++) {
            if ($countEnds === 0) {
                // No paragraphs – append at the end.
                $insertPoints[] = null;
                continue;
            }
            // Calculate target index proportionally.
            $target = (int) round(($i + 1) * $countEnds / 6);
            $insertPoints[] = $paragraphEnds[$target] ?? end($paragraphEnds);
        }

        // Insert callouts in reverse order so offsets remain valid.
        foreach (array_reverse($insertPoints, true) as $idx => $position) {
            $phone = $selected[$idx];
            $message = "Halo, saya ingin konsultasi mengenai Pelatihan K3 Konstruksi untuk wilayah {$cityName}.";
            $waUrl = WhatsApp::url($message, $phone);
            $ctaHtml = '<div class="my-6 p-4 rounded-xl bg-concrete-100 border border-concrete-300 flex flex-col sm:flex-row items-center justify-between gap-4 not-prose">'
                .'<div>'
                .'<div class="text-xs font-bold uppercase tracking-wider text-safety-600">Konsultasi K3 Konstruksi '.$cityName.'</div>'
                .'<div class="text-sm font-semibold text-navy-950">Ingin memastikan jenjang pelatihan (Muda, Madya, Utama) yang sesuai?</div>'
                .'</div>'
                .'<a href="'.$waUrl.'" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-wa-500 hover:bg-wa-600 text-white font-semibold text-xs transition shrink-0">'
                .'<span>Konsultasi WhatsApp</span> &rarr;'
                .'</a>'
                .'</div>';

            if ($position !== null) {
                $content = substr_replace($content, $ctaHtml, $position, 0);
            } else {
                $content .= $ctaHtml;
            }
        }

        $result['content'] = $content;
        return $result;
    }

    /**
     * Request a continuation from Ollama for the given partial content.
     * Returns an array with keys: success (bool) and content (string) on success.
     */
    protected function requestContinuation(string $existingContent, int $targetWords, string $cityName): array
    {
        // Build a simple continuation prompt.
        $systemPrompt = "Anda adalah editor artikel K3 konstruksi berbahasa Indonesia. Lanjutkan artikel yang diberikan dengan konten baru sekitar {$targetWords} kata. Jangan mengulang paragraf atau judul yang sudah ada. Output HANYA fragmen HTML valid menggunakan tag semantik seperti <h2>, <h3>, <p>, <ul>, <ol>, <li>, <strong>, dan <table> bila relevan. Jangan keluarkan JSON, markdown fence, komentar, atau metadata. Jika tidak dapat memenuhi seluruh target, tetap keluarkan fragmen HTML valid yang bermakna.";
        $userPrompt = "Konten artikel yang sudah ada (gunakan sebagai konteks, jangan salin ulang):\n{$existingContent}\n\nTambahkan bagian lanjutan yang relevan dan substantif sebanyak kira-kira {$targetWords} kata. Fokus pada informasi baru, contoh penerapan lapangan, prosedur, risiko, pengendalian, dan kepatuhan regulasi yang relevan. Kembalikan hanya fragmen HTML tambahan, bukan artikel lengkap.";

        try {
            $endpoint = $this->getChatEndpoint();
            $client = Http::timeout($this->timeout);
            if (! empty($this->apiKey)) {
                $client = $client->withToken($this->apiKey);
            }
            $response = $client->post($endpoint, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'stream' => false,
            ]);

            if (! $response->successful()) {
                return ['success' => false, 'error' => 'Continuation request failed with HTTP '.$response->status()];
            }

            $data = $response->json();
            $raw = $data['message']['content'] ?? '';
            if (trim($raw) === '') {
                return ['success' => false, 'error' => 'Empty continuation response'];
            }

            $parsed = $this->parseResponse($raw, $cityName, $cityName, $targetWords);
            if (empty($parsed['content'])) {
                return ['success' => false, 'error' => 'Continuation parsing produced no content'];
            }
            $continuationContent = trim($parsed['content']);
            $addedWords = $this->countWords($continuationContent);

            if ($addedWords === 0) {
                return ['success' => false, 'error' => 'Continuation contains no usable words'];
            }

            // Reject an identical response to avoid repeatedly appending the same content.
            $normalizedExisting = preg_replace('/\s+/u', ' ', strip_tags($existingContent));
            $normalizedContinuation = preg_replace('/\s+/u', ' ', strip_tags($continuationContent));

            if (
                is_string($normalizedExisting)
                && is_string($normalizedContinuation)
                && trim($normalizedContinuation) !== ''
                && str_contains($normalizedExisting, trim($normalizedContinuation))
            ) {
                return ['success' => false, 'error' => 'Continuation repeated existing content'];
            }

            // A shorter valid fragment is acceptable; generateArticle() can request another round.
            return ['success' => true, 'content' => $continuationContent];
        } catch (ConnectionException $e) {
            return ['success' => false, 'error' => 'Continuation connection error: '.$e->getMessage()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => 'Continuation exception: '.$e->getMessage()];
        }
    }

    /**
     * Count words in a string while ignoring HTML tags and decoding entities.
     *
     * @param string $content HTML content
     * @return int Number of words
     */
    protected function countWords(string $content): int
    {
        // Remove HTML tags
        $text = strip_tags($content);
        // Decode HTML entities (e.g. &amp; -> &)
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        // Normalize whitespace and split on word boundaries
        $words = preg_split('/\s+/u', trim($text));
        return $words === false ? 0 : count(array_filter($words, fn($w) => $w !== ''));
    }

    protected function sanitizeContent(string $content): string
    {
        // Replace LaTeX arrow patterns like "$ \rightarrow$" or "$ ightarrow$" with a proper arrow.
        $patterns = [
            '/\$\s*\\\\?rightarrow\s*\$/i',
            '/\$\s*ightarrow\s*\$/i',
        ];
        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '→', $content);
        }

        // Remove any remaining stray dollar signs.
        return str_replace('$', '', $content);
    }
}

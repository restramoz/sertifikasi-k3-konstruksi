@extends('layouts.app')

@section('title', 'Training K3 Konstruksi di Provinsi ' . $province['name'] . ' — Konsultasi & Informasi Program')
@section('meta_description', 'Informasi dan konsultasi pelatihan K3 Konstruksi (Muda, Madya, Utama) untuk tenaga kerja konstruksi di Provinsi ' . $province['name'] . '. Hubungi konsultan kami untuk jadwal dan persyaratan.')
@section('wa_message', $waMessage)

@section('content')
    {{-- Breadcrumb --}}
    <div class="bg-navy-950 border-b border-navy-900">
        <x-breadcrumb :items="[
            ['label' => 'Wilayah', 'url' => null],
            ['label' => $province['name'], 'url' => null],
        ]" />
    </div>

    {{-- Hero --}}
    <section class="relative bg-navy-950 text-white overflow-hidden border-b border-navy-800" aria-labelledby="prov-hero-heading">
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="grid-p" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="#FFF" stroke-width="1"/></pattern></defs>
                <rect width="100%" height="100%" fill="url(#grid-p)" />
            </svg>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-navy-900 border border-navy-700/80 text-safety-400 text-xs sm:text-sm font-semibold mb-6">
                    <span class="w-2 h-2 rounded-full bg-safety-500 animate-pulse"></span>
                    Layanan Informasi &amp; Konsultasi K3 Konstruksi
                </div>
                <h1 id="prov-hero-heading" class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight uppercase">
                    Training K3 Konstruksi<br><span class="text-safety-500">Provinsi {{ $province['name'] }}</span>
                </h1>
                <p class="mt-6 text-base sm:text-lg text-concrete-300 leading-relaxed">
                    Halaman ini menyediakan informasi konsultasi pelatihan dan sertifikasi Keselamatan dan Kesehatan Kerja (K3) bidang konstruksi bagi tenaga kerja profesional yang berdomisili atau bertugas di <strong class="text-white">Provinsi {{ $province['name'] }}</strong>.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <x-wa-cta variant="primary" size="lg" :message="$waMessage" label="Konsultasi untuk Wilayah {{ $province['name'] }}" />
                </div>
                <div class="mt-10 pt-8 border-t border-navy-800/80 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Pulau</div><div class="text-lg font-extrabold text-safety-500 mt-0.5">{{ $province['island'] }}</div></div>
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Kab/Kota</div><div class="text-lg font-extrabold text-white mt-0.5">{{ $province['total_cities'] }}</div></div>
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Jenjang</div><div class="text-lg font-extrabold text-safety-500 mt-0.5">3 Level</div></div>
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Layanan</div><div class="text-lg font-extrabold text-white mt-0.5">Konsultatif</div></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Disclaimer --}}
    <section class="py-10 bg-amber-50/80 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-sm text-amber-900 leading-relaxed">
                    <strong>Catatan penting:</strong> Halaman ini adalah halaman informasi dan konsultasi. Penyelenggaraan pelatihan fisik di kota atau kabupaten tertentu dalam Provinsi {{ $province['name'] }}, termasuk jadwal, lokasi, biaya, dan penyelenggara yang diotorisasi, harus dikonfirmasi melalui konsultasi langsung. Kami tidak mengklaim adanya kantor lokal atau penyelenggaraan tetap tanpa verifikasi resmi.
                </p>
            </div>
        </div>
    </section>

    {{-- Program Links --}}
    <section id="program" class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="prov-program-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-safety-600 bg-safety-soft px-3 py-1 rounded-full">3 Jenjang Pelatihan</span>
                <h2 id="prov-program-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Program K3 Konstruksi yang Tersedia
                </h2>
                <p class="mt-4 text-base text-concrete-600">Pilih jenjang yang sesuai dengan peran dan tanggung jawab Anda di proyek konstruksi.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($programs as $prog)
                <a href="{{ route($prog['route_name']) }}" class="group flex flex-col bg-white rounded-xl border border-concrete-200 hover:border-safety-400 hover:shadow-md transition-all overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500">
                    <div class="h-1.5 {{ match($prog['level']) { 'Muda' => 'bg-concrete-500', 'Madya' => 'bg-safety-500', 'Utama' => 'bg-navy-900', default => 'bg-safety-500' } }}"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="text-xs font-bold uppercase tracking-wider text-concrete-500 mb-1">{{ $prog['badge'] }}</div>
                        <h3 class="text-xl font-bold text-navy-950 mb-2 group-hover:text-safety-600 transition-colors">{{ $prog['title'] }} — {{ $province['name'] }}</h3>
                        <p class="text-sm text-concrete-600 flex-1 leading-relaxed">{{ $prog['hero_subheading'] }}</p>
                        <p class="mt-3 text-xs text-concrete-500 leading-relaxed">{{ $prog['introduction'] }}</p>
                        <div class="mt-5 text-xs font-bold text-safety-600 flex items-center gap-1">Lihat Detail {{ $prog['title'] }} &rarr;</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Cities in Province --}}
    @if(count($province['cities']) > 0)
    <section id="kota" class="py-14 sm:py-20 bg-white border-b border-concrete-200" aria-labelledby="prov-kota-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="prov-kota-heading" class="text-2xl font-extrabold text-navy-950 mb-8">
                Kab/Kota di Provinsi {{ $province['name'] }}
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                @foreach($province['cities'] as $c)
                <a href="{{ route('regional.city', $c['slug']) }}" class="block px-3 py-2.5 rounded-lg bg-concrete-50 border border-concrete-200 hover:border-safety-400 hover:bg-safety-soft text-sm font-medium text-navy-900 hover:text-safety-700 transition-colors truncate focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500">
                    {{ $c['name'] }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- FAQ --}}
    <section id="faq" class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="prov-faq-heading">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-safety-600 bg-safety-soft px-3 py-1 rounded-full">Tanya Jawab</span>
                <h2 id="prov-faq-heading" class="mt-3 text-2xl font-extrabold text-navy-950 tracking-tight">FAQ: K3 Konstruksi di {{ $province['name'] }}</h2>
            </div>
            <div class="space-y-4">
                @foreach([
                    [
                        'q' => 'Apakah pelatihan K3 Konstruksi tersedia di wilayah Provinsi ' . $province['name'] . '?',
                        'a' => 'Kami menyediakan layanan informasi dan konsultasi untuk calon peserta dari Provinsi ' . $province['name'] . '. Ketersediaan jadwal pelatihan, lokasi penyelenggaraan, dan detail operasional dikonfirmasi langsung melalui konsultan kami — tidak ada klaim penyelenggaraan tetap tanpa verifikasi.',
                    ],
                    [
                        'q' => 'Jenjang apa saja yang tersedia untuk K3 Konstruksi?',
                        'a' => 'Tersedia tiga jenjang resmi: Training K3 Konstruksi Muda (tingkat pertama/operasional lapangan), Training K3 Konstruksi Madya (tingkat koordinator & supervisor), dan Training K3 Konstruksi Utama (tingkat manajerial). Setiap jenjang memiliki kurikulum dan persyaratan yang terstandardisasi.',
                    ],
                    [
                        'q' => 'Bagaimana cara mendapatkan informasi jadwal dan biaya pelatihan?',
                        'a' => 'Hubungi konsultan kami melalui WhatsApp. Tim kami akan menginformasikan batch terdekat, rincian investasi, dan persyaratan berkas administrasi secara transparan.',
                    ],
                    [
                        'q' => 'Apakah tersedia pelatihan in-house untuk perusahaan di ' . $province['name'] . '?',
                        'a' => 'Kemungkinan pelatihan in-house untuk korporasi di wilayah Provinsi ' . $province['name'] . ' dapat dikonsultasikan. Tim kami menyiapkan proposal formal sesuai kebutuhan spesifik perusahaan Anda.',
                    ],
                ] as $faq)
                <details class="group bg-white rounded-xl border border-concrete-200 p-5 sm:p-6 open:border-safety-400">
                    <summary class="flex justify-between items-center gap-4 font-bold text-navy-950 cursor-pointer list-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                        <span>{{ $faq['q'] }}</span>
                        <span class="w-7 h-7 rounded-full bg-concrete-100 flex items-center justify-center shrink-0 group-open:rotate-180 transition-transform">
                            <svg class="w-4 h-4 text-concrete-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <p class="mt-4 pt-4 border-t border-concrete-100 text-sm text-concrete-700 leading-relaxed">{{ $faq['a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="py-16 sm:py-24 bg-navy-950 text-white" aria-labelledby="prov-cta-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 id="prov-cta-heading" class="text-2xl sm:text-3xl font-extrabold uppercase tracking-tight">
                    Konsultasi K3 Konstruksi<br><span class="text-safety-500">Provinsi {{ $province['name'] }}</span>
                </h2>
                <p class="mt-4 text-base text-concrete-300 leading-relaxed">
                    Hubungi konsultan kami untuk mendapatkan informasi jadwal, biaya, dan panduan kelengkapan berkas administrasi yang sesuai dengan kebutuhan Anda.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <x-wa-cta variant="primary" size="lg" :message="$waMessage" label="Konsultasi Sekarang" />
                    <x-button :href="route('home')" variant="outline" size="lg" class="text-white border-concrete-500 hover:bg-navy-900">Kembali ke Beranda</x-button>
                </div>
                <div class="mt-10 pt-8 border-t border-navy-800/80 flex flex-wrap justify-center gap-6 text-xs text-concrete-400">
                    <a href="{{ route('program.muda') }}" class="hover:text-safety-400 transition-colors">Training K3 Konstruksi Muda</a>
                    <span>·</span>
                    <a href="{{ route('program.madya') }}" class="hover:text-safety-400 transition-colors">Training K3 Konstruksi Madya</a>
                    <span>·</span>
                    <a href="{{ route('program.utama') }}" class="hover:text-safety-400 transition-colors">Training K3 Konstruksi Utama</a>
                </div>
            </div>
        </div>
    </section>
@endsection

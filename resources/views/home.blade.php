@extends('layouts.app')

@section('title', 'Layanan Pelatihan & Sertifikasi K3 Konstruksi')
@section('meta_description', 'Portal informasi dan konsultasi resmi pelatihan K3 Konstruksi (Muda, Madya, Utama) untuk meningkatkan standar keselamatan kerja proyek konstruksi di Indonesia.')

@section('content')
@php
    // Load all provinces for the "Jelajahi Wilayah" directory
    $regionalService = resolve(App\Services\RegionalService::class);
    $provinces = $regionalService->getAllProvinces();
@endphp
    <!-- HERO SECTION -->
    <section class="relative bg-navy-950 text-white overflow-hidden border-b border-navy-800" aria-labelledby="hero-heading">
        <!-- Subtle Industrial Accent Lines / Grid -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#FFFFFF" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-28">
            <div class="max-w-3xl">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-navy-900 border border-navy-700/80 text-safety-400 text-xs sm:text-sm font-semibold mb-6 shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-safety-500 animate-pulse"></span>
                    Standar Keselamatan Kerja Sektor Konstruksi
                </div>

                <!-- Main Heading -->
                <h1 id="hero-heading" class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight uppercase">
                    Wujudkan Proyek Zero Accident dengan <span class="text-safety-500">Sertifikasi K3 Konstruksi</span>
                </h1>

                <!-- Subheading -->
                <p class="mt-6 text-base sm:text-lg lg:text-xl text-concrete-300 leading-relaxed">
                    Tingkatkan kualifikasi dan kompetensi keselamatan kerja bagi tenaga ahli konstruksi di seluruh Indonesia. Tersedia jenjang pembinaan terstruktur untuk level Muda, Madya, hingga Utama.
                </p>

                <!-- Actions -->
                <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <x-wa-cta variant="primary" size="lg" label="Konsultasi Program via WhatsApp" class="shadow-md" />
                    <x-button href="#program" variant="outline" size="lg" class="text-white border-concrete-500 hover:bg-navy-900">
                        Lihat 3 Jenjang Program
                    </x-button>
                </div>

                <!-- Value Highlights Grid -->
                <div class="mt-12 pt-8 border-t border-navy-800/80 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-safety-500">3 Jenjang</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">Muda, Madya, Utama</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">Nasional</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">Regulasi Standar K3</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-safety-500">Praktis</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">Relevan Kondisi Proyek</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">Responsif</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">Layanan Bimbingan WA</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PROGRAM SECTION -->
    <section id="program" class="py-16 sm:py-24 bg-concrete-50" aria-labelledby="program-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-safety-600 bg-safety-soft px-3 py-1 rounded-full">
                    Jenjang Pembinaan
                </span>
                <h2 id="program-heading" class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-navy-950 tracking-tight">
                    Tiga Jenjang Sertifikasi K3 Konstruksi
                </h2>
                <p class="mt-4 text-base text-concrete-500">
                    Pilih program pelatihan dan bimbingan keselamatan yang sesuai dengan peran, wewenang, dan tanggung jawab teknis Anda di proyek.
                </p>
            </div>

            <!-- Program Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                <!-- Card 1: Muda -->
                <div class="flex flex-col bg-white rounded-xl border border-concrete-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <div class="h-2 bg-concrete-500"></div>
                    <div class="p-6 sm:p-8 flex-1 flex flex-col">
                        <div class="text-xs font-bold uppercase tracking-wider text-concrete-500 mb-2">Tingkat Pertama</div>
                        <h3 class="text-xl font-bold text-navy-950 mb-3">
                            Training K3 Konstruksi Muda
                        </h3>
                        <p class="text-sm text-concrete-500 leading-relaxed mb-6">
                            Dirancang untuk pelaksana dan pengawas lapangan yang bertanggung jawab langsung memastikan kepatuhan prosedur keselamatan dan penggunaan APD harian di zona kerja proyek.
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-concrete-100 space-y-3 mb-6">
                            <div class="text-xs font-semibold text-navy-900 uppercase tracking-wider">Fokus Kompetensi:</div>
                            <ul class="text-xs text-concrete-700 space-y-2" role="list">
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Identifikasi bahaya dan pengendalian risiko harian</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Pengawasan kepatuhan APD & rambu keselamatan</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Pelaporan insiden dan tindakan tanggap darurat</span>
                                </li>
                            </ul>
                        </div>

                        <div class="space-y-2.5">
                            <x-wa-cta variant="secondary" size="md" message="Halo, saya ingin konsultasi mengenai pendaftaran Training K3 Konstruksi Muda." label="Konsultasi Jenjang Muda" class="w-full justify-center" />
                            <a href="{{ route('program.muda') }}" class="inline-flex items-center justify-center w-full text-xs font-bold text-navy-900 hover:text-safety-600 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                                Pelajari Detail Program Muda &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Madya (Featured) -->
                <div class="flex flex-col bg-white rounded-xl border-2 border-safety-500 shadow-md relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-safety-500 text-navy-950 font-extrabold text-[11px] uppercase tracking-wider px-3 py-1 rounded-bl-lg">
                        Populer
                    </div>
                    <div class="h-2 bg-safety-500"></div>
                    <div class="p-6 sm:p-8 flex-1 flex flex-col">
                        <div class="text-xs font-bold uppercase tracking-wider text-safety-600 mb-2">Tingkat Lanjutan</div>
                        <h3 class="text-xl font-bold text-navy-950 mb-3">
                            Training K3 Konstruksi Madya
                        </h3>
                        <p class="text-sm text-concrete-500 leading-relaxed mb-6">
                            Ditujukan bagi koordinator K3, site manager, dan supervisor yang merencanakan rencana keselamatan kerja (RKK/RK3K) serta mengoordinasikan keselamatan lintas subkontraktor.
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-concrete-100 space-y-3 mb-6">
                            <div class="text-xs font-semibold text-navy-900 uppercase tracking-wider">Fokus Kompetensi:</div>
                            <ul class="text-xs text-concrete-700 space-y-2" role="list">
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Penyusunan dokumen Rencana Keselamatan Konstruksi</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Manajemen risiko pekerjaan berisiko tinggi (ketinggian & galian)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Audit internal berkala dan investigasi kecelakaan kerja</span>
                                </li>
                            </ul>
                        </div>

                        <div class="space-y-2.5">
                            <x-wa-cta variant="primary" size="md" message="Halo, saya ingin konsultasi mengenai pendaftaran Training K3 Konstruksi Madya." label="Konsultasi Jenjang Madya" class="w-full justify-center" />
                            <a href="{{ route('program.madya') }}" class="inline-flex items-center justify-center w-full text-xs font-bold text-navy-900 hover:text-safety-600 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                                Pelajari Detail Program Madya &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Utama -->
                <div class="flex flex-col bg-white rounded-xl border border-concrete-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <div class="h-2 bg-navy-900"></div>
                    <div class="p-6 sm:p-8 flex-1 flex flex-col">
                        <div class="text-xs font-bold uppercase tracking-wider text-navy-700 mb-2">Tingkat Manajerial</div>
                        <h3 class="text-xl font-bold text-navy-950 mb-3">
                            Training K3 Konstruksi Utama
                        </h3>
                        <p class="text-sm text-concrete-500 leading-relaxed mb-6">
                            Diperuntukkan bagi tenaga ahli utama, pimpinan proyek (Project Director/Manager), dan direksi yang mengarahkan kebijakan strategis SMK3 di proyek berskala besar atau kompleks.
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-concrete-100 space-y-3 mb-6">
                            <div class="text-xs font-semibold text-navy-900 uppercase tracking-wider">Fokus Kompetensi:</div>
                            <ul class="text-xs text-concrete-700 space-y-2" role="list">
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Penyusunan kebijakan dan strategi SMK3 korporasi</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Evaluasi kinerja keselamatan pada megaproyek konstruksi</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-safety-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>Kepemimpinan keselamatan kerja & kepatuhan regulasi</span>
                                </li>
                            </ul>
                        </div>

                        <div class="space-y-2.5">
                            <x-wa-cta variant="secondary" size="md" message="Halo, saya ingin konsultasi mengenai pendaftaran Training K3 Konstruksi Utama." label="Konsultasi Jenjang Utama" class="w-full justify-center" />
                            <a href="{{ route('program.utama') }}" class="inline-flex items-center justify-center w-full text-xs font-bold text-navy-900 hover:text-safety-600 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                                Pelajari Detail Program Utama &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN SECTION -->
    <section id="keunggulan" class="py-16 sm:py-24 bg-white border-t border-concrete-200" aria-labelledby="keunggulan-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-safety-600 bg-safety-soft px-3 py-1 rounded-full">
                    Mengapa Memilih Kami
                </span>
                <h2 id="keunggulan-heading" class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-navy-950 tracking-tight">
                    Keunggulan Layanan Bimbingan K3 Konstruksi
                </h2>
                <p class="mt-4 text-base text-concrete-500">
                    Kami memprioritaskan pemahaman regulasi mendalam, kepraktisan implementasi lapangan, dan kemudahan konsultasi bagi perusahaan maupun profesional mandiri.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Pillar 1 -->
                <div class="p-6 rounded-xl bg-concrete-50 border border-concrete-200">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-safety-500 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Sesuai Regulasi Nasional</h3>
                    <p class="text-sm text-concrete-500 leading-relaxed">
                        Materi pembinaan mengacu pada perundangan dan standar keselamatan konstruksi terkini di Indonesia.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="p-6 rounded-xl bg-concrete-50 border border-concrete-200">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-safety-500 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Praktik Lapangan Nyata</h3>
                    <p class="text-sm text-concrete-500 leading-relaxed">
                        Fokus pada studi kasus nyata pekerjaan berisiko: pekerjaan tanah, scaffolding, alat berat, dan ruang terbatas.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="p-6 rounded-xl bg-concrete-50 border border-concrete-200">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-safety-500 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Konsultasi Terpandu</h3>
                    <p class="text-sm text-concrete-500 leading-relaxed">
                        Tim konsultan kami siap membantu memeriksa kesesuaian berkas portofolio dan rekomendasi jenjang yang tepat.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="p-6 rounded-xl bg-concrete-50 border border-concrete-200">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-safety-500 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Alur Cepat & Transparan</h3>
                    <p class="text-sm text-concrete-500 leading-relaxed">
                        Alur pendaftaran sederhana dengan koordinasi langsung via WhatsApp tanpa birokrasi berbelit.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="py-16 sm:py-24 bg-concrete-50 border-t border-concrete-200" aria-labelledby="faq-heading">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-safety-600 bg-safety-soft px-3 py-1 rounded-full">
                    Tanya Jawab
                </span>
                <h2 id="faq-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="mt-3 text-sm sm:text-base text-concrete-500">
                    Informasi mendasar seputar pelatihan dan sertifikasi K3 Konstruksi.
                </p>
            </div>

            <div class="space-y-4">
                <details class="group bg-white rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                        <span>Apa perbedaan mendasar antara jenjang Muda, Madya, dan Utama?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-500 leading-relaxed">
                        Perbedaan terletak pada cakupan wewenang dan tanggung jawab di proyek. Jenjang Muda berfokus pada pengawasan harian dan kepatuhan lapangan; jenjang Madya mengoordinasikan Rencana Keselamatan Konstruksi (RKK) dan manajemen risiko; sedangkan jenjang Utama merumuskan kebijakan strategis serta tata kelola keselamatan proyek skala besar.
                    </p>
                </details>

                <details class="group bg-white rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                        <span>Mengapa sertifikasi K3 Konstruksi wajib bagi pelaku industri konstruksi?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-500 leading-relaxed">
                        Industri konstruksi memiliki tingkat risiko kecelakaan kerja yang tinggi. Memiliki tenaga kerja bersertifikasi K3 Konstruksi merupakan mandat kepatuhan hukum untuk mencegah insiden fatal, melindungi pekerja, dan memenuhi persyaratan kualifikasi tender proyek nasional.
                    </p>
                </details>

                <details class="group bg-white rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                        <span>Bagaimana cara mengetahui jenjang mana yang paling tepat untuk saya?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-500 leading-relaxed">
                        Penentuan jenjang didasarkan pada latar belakang pendidikan teknik, pengalaman kerja di proyek konstruksi, dan posisi yang Anda emban saat ini. Anda dapat berkonsultasi langsung melalui WhatsApp agar tim kami dapat memetakan kualifikasi Anda ke jenjang yang paling sesuai.
                    </p>
                </details>

                <details class="group bg-white rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                        <span>Bagaimana alur pendaftaran dan konsultasi bimbingan?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-500 leading-relaxed">
                        Alur dimulai dengan menghubungi tim konsultan kami via WhatsApp. Kami akan menginformasikan persyaratan berkas, jadwal bimbingan terdekat, serta memberikan panduan persiapan administrasi hingga selesai.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <!-- FINAL CTA BANNER -->
    <section id="kontak" class="bg-navy-950 text-white py-16 sm:py-20 border-t border-navy-800 relative overflow-hidden" aria-labelledby="cta-heading">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider text-safety-400 bg-navy-900 rounded-full border border-navy-700 mb-4">
                Konsultasi & Informasi Jadwal
            </span>
            <h2 id="cta-heading" class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight uppercase">
                Siapkan Kompetensi K3 Konstruksi Anda Hari Ini
            </h2>
            <p class="mt-4 text-base sm:text-lg text-concrete-300 max-w-2xl mx-auto leading-relaxed">
                Hubungi konsultan kami melalui WhatsApp untuk mendapatkan panduan jenjang yang sesuai, informasi kelengkapan berkas, dan jadwal pembinaan.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-wa-cta variant="primary" size="lg" label="Konsultasi via WhatsApp Sekarang" class="shadow-lg" />
            </div>
        </div>
    </section>

    <!-- REGION DIRECTORY SECTION -->
    <section id="wilayah" class="py-14 bg-concrete-50" aria-label="Jelajahi Wilayah">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-extrabold text-navy-950 mb-6">Jelajahi Wilayah</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($provinces as $prov)
                    <a href="{{ route('regional.province', $prov['slug']) }}" class="block p-4 bg-white rounded-lg border border-concrete-200 hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-navy-950">{{ $prov['name'] }}</span>
                            @if(!empty($prov['total_cities']))
                                <span class="text-xs text-concrete-500">{{ $prov['total_cities'] }} Kota/Kabupaten</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection

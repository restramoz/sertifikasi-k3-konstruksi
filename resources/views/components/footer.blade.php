<footer class="bg-navy-950 text-concrete-300 border-t border-navy-800" role="contentinfo" aria-label="Informasi Kaki Halaman">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24 sm:py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Col 1: Identity -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-navy-900 border border-navy-700 flex items-center justify-center text-safety-500 shadow-inner">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 2L3 7v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-9-5z"/>
                            <path d="M12 8v4"/>
                            <path d="M12 16h.01"/>
                        </svg>
                    </div>
                    <span class="text-base font-bold text-white tracking-tight uppercase">
                        Sertifikasi <span class="text-safety-500">K3 Konstruksi</span>
                    </span>
                </div>
                <p class="text-sm text-concrete-300 leading-relaxed">
                    Penyedia layanan informasi, pelatihan, dan bimbingan sertifikasi keselamatan dan kesehatan kerja (K3) bidang konstruksi untuk tenaga kerja profesional di seluruh Indonesia.
                </p>
                <div class="pt-1">
                    <x-wa-cta variant="wa" size="sm" label="Konsultasi WhatsApp" />
                </div>
            </div>

            <!-- Col 2: Programs -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                    Program Sertifikasi
                </h3>
                <ul class="space-y-2.5 text-sm" role="list">
                    <li>
                        <a href="{{ route('program.muda') }}" class="hover:text-safety-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                            Training K3 Konstruksi Muda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.madya') }}" class="hover:text-safety-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                            Training K3 Konstruksi Madya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.utama') }}" class="hover:text-safety-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                            Training K3 Konstruksi Utama
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 3: Navigation & Info -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                    Informasi & Panduan
                </h3>
                <ul class="space-y-2.5 text-sm" role="list">
                    <li>
                        <a href="{{ route('home') }}#keunggulan" class="hover:text-safety-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                            Keunggulan Layanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.index') }}" class="hover:text-safety-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                            Artikel K3 Konstruksi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#faq" class="hover:text-safety-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                            Pertanyaan Umum (FAQ)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#kontak" class="hover:text-safety-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 rounded">
                            Hubungi Tim Konsultan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Safety Commitment Notice -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                    Komitmen Keselamatan
                </h3>
                <p class="text-xs text-concrete-300 leading-relaxed">
                    Mewujudkan lingkungan kerja konstruksi tanpa kecelakaan (<span class="text-concrete-100 font-semibold">Zero Accident</span>) melalui peningkatan kompetensi keselamatan kerja sesuai regulasi keselamatan konstruksi nasional.
                </p>
                <div class="flex items-center gap-2 text-xs text-concrete-300">
                    <span class="inline-block w-2 h-2 rounded-full bg-safety-500"></span>
                    <span>Respon konsultasi cepat setiap hari kerja</span>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="mt-12 pt-8 border-t border-navy-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-concrete-500">
            <p>
                &copy; {{ date('Y') }} Sertifikasi K3 Konstruksi. Seluruh hak cipta dilindungi.
            </p>
            <p class="text-concrete-500">
                Layanan Informasi & Pelatihan K3 Sektor Konstruksi
            </p>
        </div>
    </div>
</footer>

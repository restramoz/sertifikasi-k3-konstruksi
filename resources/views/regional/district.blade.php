@extends('layouts.app')

{{-- District pages are intentionally noindex: content is thin until meaningful local detail is available --}}
@section('robots', 'noindex, follow')

@section('title', 'K3 Konstruksi — Kecamatan ' . $district['name'] . ', ' . $district['city_name'])
@section('meta_description', 'Halaman referensi wilayah administratif Kecamatan ' . $district['name'] . ' di ' . $district['city_name'] . '. Konsultasi pelatihan K3 Konstruksi tersedia melalui WhatsApp.')
@section('wa_message', $waMessage)

@section('content')
    {{-- Breadcrumb --}}
    <div class="bg-navy-950 border-b border-navy-900">
        <x-breadcrumb :items="[
            ['label' => 'Wilayah', 'url' => null],
            ['label' => $district['province'], 'url' => route('regional.province', $district['province_slug'])],
            ['label' => $district['city_name'], 'url' => route('regional.city', $district['city_slug'])],
            ['label' => $district['name'], 'url' => null],
        ]" />
    </div>

    {{-- Hero (compact — thin page) --}}
    <section class="relative bg-navy-950 text-white overflow-hidden border-b border-navy-800" aria-labelledby="dist-hero-heading">
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="grid-d" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="#FFF" stroke-width="1"/></pattern></defs>
                <rect width="100%" height="100%" fill="url(#grid-d)" />
            </svg>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-navy-900 border border-navy-700/80 text-safety-400 text-xs sm:text-sm font-semibold mb-6">
                    <span class="w-2 h-2 rounded-full bg-safety-500 animate-pulse"></span>
                    Halaman Referensi Wilayah
                </div>
                <h1 id="dist-hero-heading" class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase">
                    K3 Konstruksi – Kecamatan <span class="text-safety-500">{{ $district['name'] }}</span>
                </h1>
                <p class="mt-4 text-base text-concrete-300 leading-relaxed">
                    Halaman ini adalah halaman referensi wilayah untuk <strong class="text-white">Kecamatan {{ $district['name'] }}</strong>, <a href="{{ route('regional.city', $district['city_slug']) }}" class="text-safety-400 hover:text-safety-300 underline">{{ $district['city_name'] }}</a>, Provinsi {{ $district['province'] }}.
                    Untuk informasi pelatihan K3 Konstruksi, gunakan tombol konsultasi di bawah.
                </p>
                <div class="mt-6">
                    <x-wa-cta variant="primary" size="md" :message="$waMessage" label="Konsultasi K3 Konstruksi" />
                </div>
            </div>
        </div>
    </section>

    {{-- Thin-content notice --}}
    <section class="py-8 bg-concrete-100 border-b border-concrete-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-start gap-4">
                <svg class="w-5 h-5 text-concrete-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-concrete-600 leading-relaxed">
                    Halaman ini menyediakan informasi awal tingkat kecamatan. Jadwal pelatihan, lokasi, biaya, prasyarat, dan penyelenggara yang diotorisasi dikonfirmasi melalui konsultasi. Tidak ada klaim ketersediaan lokal tanpa verifikasi resmi.
                </p>
            </div>
        </div>
    </section>

    {{-- Program Links --}}
    <section class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="dist-program-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="dist-program-heading" class="text-xl font-extrabold text-navy-950 mb-8">Program K3 Konstruksi yang Tersedia</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($programs as $prog)
                <a href="{{ route('city.program.detail', ['city' => $district['city_slug'], 'program' => strtolower($prog['level'])]) }}" class="group flex flex-col bg-white rounded-xl border border-concrete-200 hover:border-safety-400 hover:shadow-md transition-all overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500">
                    <div class="h-1.5 {{ match($prog['level']) { 'Muda' => 'bg-concrete-500', 'Madya' => 'bg-safety-500', 'Utama' => 'bg-navy-900', default => 'bg-safety-500' } }}"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="text-xs font-bold uppercase tracking-wider text-concrete-500 mb-1">{{ $prog['badge'] }}</div>
                        <h3 class="text-xl font-bold text-navy-950 mb-2 group-hover:text-safety-600 transition-colors">{{ $prog['title'] }} — Kecamatan {{ $district['name'] }}, {{ $district['city_name'] }}</h3>
                        <p class="text-sm text-concrete-600 flex-1 leading-relaxed">{{ $prog['hero_subheading'] }}</p>
                        <p class="mt-3 text-xs text-concrete-500 leading-relaxed">{{ $prog['introduction'] }}</p>
                        <div class="mt-5 text-xs font-bold text-safety-600 flex items-center gap-1">Lihat Detail {{ $prog['title'] }} &rarr;</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Sibling Districts --}}
    @if(isset($district['sibling_districts']) && count($district['sibling_districts']) > 0)
    <section class="py-10 bg-white border-b border-concrete-200" aria-labelledby="dist-sibling-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="dist-sibling-heading" class="text-lg font-bold text-navy-950 mb-5">
                Kecamatan Lain di {{ $district['city_name'] }}
            </h2>
            <div class="flex flex-wrap gap-2">
                @foreach(array_slice($district['sibling_districts'], 0, 12) as $sib)
                <a href="{{ route('regional.district', [$district['city_slug'], $sib['slug']]) }}" class="inline-flex px-3 py-1.5 rounded-full bg-concrete-50 border border-concrete-200 hover:border-safety-400 text-sm text-navy-700 hover:text-safety-700 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500">
                    {{ $sib['name'] }}
                </a>
                @endforeach
                <a href="{{ route('regional.city', $district['city_slug']) }}" class="inline-flex px-3 py-1.5 rounded-full bg-safety-soft border border-safety-300 text-sm font-semibold text-safety-700 hover:bg-safety-100 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500">
                    Lihat semua kecamatan {{ $district['city_name'] }} &rarr;
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Final CTA --}}
    <section class="py-14 sm:py-20 bg-navy-950 text-white" aria-labelledby="dist-cta-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-2xl mx-auto">
                <h2 id="dist-cta-heading" class="text-xl sm:text-2xl font-extrabold uppercase tracking-tight">
                    Konsultasi K3 Konstruksi<br><span class="text-safety-500">Kecamatan {{ $district['name'] }}</span>
                </h2>
                <p class="mt-4 text-sm text-concrete-300 leading-relaxed">
                    Hubungi konsultan kami untuk mendapatkan informasi jadwal, biaya, dan panduan kelengkapan berkas administrasi yang sesuai dengan kebutuhan Anda.
                </p>
                <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <x-wa-cta variant="primary" size="lg" :message="$waMessage" label="Konsultasi Sekarang" />
                    <x-button :href="route('regional.city', $district['city_slug'])" variant="outline" size="lg" class="text-white border-concrete-500 hover:bg-navy-900">{{ $district['city_name'] }}</x-button>
                </div>
            </div>
        </div>
    </section>
@endsection

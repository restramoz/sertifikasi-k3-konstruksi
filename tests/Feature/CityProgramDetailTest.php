<?php

namespace Tests\Feature;

use Tests\TestCase;

class CityProgramDetailTest extends TestCase
{
    /**
     * Ensure all three program levels render complete canonical content with personalized city context.
     */
    public function test_all_three_programs_render_canonical_content_with_city_context(): void
    {
        // 1. Muda in Bandung
        $responseMuda = $this->get(route('city.program.detail', ['city' => 'bandung', 'program' => 'muda']));
        $responseMuda->assertStatus(200);
        $responseMuda->assertSee('Training K3 Konstruksi Muda — Kota Bandung');
        $responseMuda->assertSee('Tingkat Pertama / Operasional Lapangan');
        $responseMuda->assertSee('Training K3 Konstruksi Muda diselenggarakan untuk membekali tenaga kerja operasional');
        $responseMuda->assertSee('Pelaksana teknis lapangan dan mandor proyek konstruksi sipil maupun gedung.');
        $responseMuda->assertSee('Inspeksi Kepatuhan APD & APK');
        $responseMuda->assertSee('Kerangka dasar perundangan keselamatan & kesehatan kerja sektor konstruksi');
        $responseMuda->assertSee('Jadwal Pelatihan');
        $responseMuda->assertSee('Apakah calon peserta tanpa pengalaman K3 sebelumnya dapat mendaftar?');
        $responseMuda->assertDontSee('Konten detail program belum tersedia.');

        // 2. Madya in Malang
        $responseMadya = $this->get(route('city.program.detail', ['city' => 'malang', 'program' => 'madya']));
        $responseMadya->assertStatus(200);
        $responseMadya->assertSee('Training K3 Konstruksi Madya — Kota Malang');
        $responseMadya->assertSee('Tingkat Lanjutan / Koordinator & Supervisor');
        $responseMadya->assertSee('Training K3 Konstruksi Madya ditujukan bagi tenaga ahli dan koordinator keselamatan kerja');
        $responseMadya->assertSee('Penyusunan Rencana Keselamatan Konstruksi (RKK)');
        $responseMadya->assertDontSee('Konten detail program belum tersedia.');

        // 3. Utama in Kabupaten Malang
        $responseUtama = $this->get(route('city.program.detail', ['city' => 'kab-malang', 'program' => 'utama']));
        $responseUtama->assertStatus(200);
        $responseUtama->assertSee('Training K3 Konstruksi Utama — Kabupaten Malang');
        $responseUtama->assertSee('Tingkat Manajerial / Penanggung Jawab Proyek');
        $responseUtama->assertSee('Training K3 Konstruksi Utama diselenggarakan untuk pimpinan eksekutif');
        $responseUtama->assertSee('Penetapan Kebijakan Strategis SMK3 Korporasi');
        $responseUtama->assertDontSee('Konten detail program belum tersedia.');
    }

    /**
     * Ensure full program slugs (e.g. k3-konstruksi-muda) also resolve properly.
     */
    public function test_full_program_slugs_resolve_correctly(): void
    {
        $response = $this->get(route('city.program.detail', ['city' => 'bandung', 'program' => 'k3-konstruksi-muda']));
        $response->assertStatus(200);
        $response->assertSee('Training K3 Konstruksi Muda — Kota Bandung');
    }

    /**
     * Invalid city slug should return 404.
     */
    public function test_invalid_city_returns_404(): void
    {
        $response = $this->get(route('city.program.detail', ['city' => 'nonexistent-city', 'program' => 'muda']));
        $response->assertStatus(404);
    }

    /**
     * Invalid program slug should return 404.
     */
    public function test_invalid_program_returns_404(): void
    {
        $response = $this->get(route('city.program.detail', ['city' => 'bandung', 'program' => 'invalid']));
        $response->assertStatus(404);
    }
}

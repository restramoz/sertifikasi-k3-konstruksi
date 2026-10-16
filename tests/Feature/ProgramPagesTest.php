<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProgramPagesTest extends TestCase
{
    public function test_all_three_program_routes_render_successfully(): void
    {
        $routes = [
            route('program.muda') => 'Training K3 Konstruksi Muda',
            route('program.madya') => 'Training K3 Konstruksi Madya',
            route('program.utama') => 'Training K3 Konstruksi Utama',
        ];

        foreach ($routes as $url => $expectedHeading) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertSee($expectedHeading);
        }
    }

    public function test_program_routes_have_expected_url_paths(): void
    {
        $this->assertEquals('/program/k3-konstruksi-muda', parse_url(route('program.muda'), PHP_URL_PATH));
        $this->assertEquals('/program/k3-konstruksi-madya', parse_url(route('program.madya'), PHP_URL_PATH));
        $this->assertEquals('/program/k3-konstruksi-utama', parse_url(route('program.utama'), PHP_URL_PATH));
    }

    public function test_each_program_has_distinct_page_title_and_meta_description(): void
    {
        $muda = $this->get(route('program.muda'));
        $madya = $this->get(route('program.madya'));
        $utama = $this->get(route('program.utama'));

        $muda->assertStatus(200);
        $madya->assertStatus(200);
        $utama->assertStatus(200);

        // Verify distinct titles
        $mudaTitle = 'Training K3 Konstruksi Muda — Pelatihan & Sertifikasi Keselamatan Konstruksi Lapangan';
        $madyaTitle = 'Training K3 Konstruksi Madya — Pelatihan Koordinator & Rencana Keselamatan Konstruksi';
        $utamaTitle = 'Training K3 Konstruksi Utama — Manajemen Strategis Keselamatan Proyek Konstruksi';

        $muda->assertSee($mudaTitle);
        $madya->assertSee($madyaTitle);
        $utama->assertSee($utamaTitle);

        // Check distinct meta descriptions
        $mudaMeta = 'Program pelatihan K3 Konstruksi Muda untuk pelaksana teknis, pengawas lapangan, dan mandor dalam penerapan standar keselamatan kerja operasional harian di proyek konstruksi.';
        $madyaMeta = 'Program pelatihan K3 Konstruksi Madya untuk supervisor, koordinator K3, dan site engineer dalam perumusan dokumen RKK dan manajemen risiko kerja konstruksi.';
        $utamaMeta = 'Program pelatihan K3 Konstruksi Utama bagi pimpinan proyek, direktur teknis, dan manajer senior dalam tata kelola strategis keselamatan konstruksi nasional.';

        $muda->assertSee($mudaMeta, false);
        $madya->assertSee($madyaMeta, false);
        $utama->assertSee($utamaMeta, false);

        // Ensure descriptions are distinct between pages
        $this->assertNotEquals($mudaMeta, $madyaMeta);
        $this->assertNotEquals($madyaMeta, $utamaMeta);
        $this->assertNotEquals($mudaMeta, $utamaMeta);
    }

    public function test_program_pages_include_accessible_breadcrumbs(): void
    {
        $response = $this->get(route('program.muda'));

        $response->assertStatus(200);
        $response->assertSee('aria-label="Breadcrumb"', false);
        $response->assertSee('itemtype="https://schema.org/BreadcrumbList"', false);
        $response->assertSee('href="' . route('home') . '"', false);
        $response->assertSee('Beranda', false);
        $response->assertSee('Program Pelatihan', false);
        $response->assertSee('aria-current="page"', false);
    }

    public function test_program_pages_distinguish_field_practice_from_formal_requirements(): void
    {
        $response = $this->get(route('program.muda'));

        $response->assertStatus(200);
        $response->assertSee('Peran &amp; Tanggung Jawab Potensial di Proyek', false);
        $response->assertSee('Perhatian: Pembedaan Praktik Kerja Lapangan &amp; Persyaratan Sertifikasi', false);
        $response->assertSee('Uraian peran di atas merupakan ringkasan umum tugas operasional');
    }

    public function test_program_pages_display_transparent_unverified_info_notice(): void
    {
        $response = $this->get(route('program.muda'));

        $response->assertStatus(200);
        $response->assertSee('Informasi Penyelenggaraan Pelatihan');
        $response->assertSee('Dikonfirmasi per batch');
        $response->assertSee('Menyesuaikan silabus resmi');
        $response->assertSee('Komitmen Keterbukaan Informasi Kami');
        $response->assertSee('Kami tidak menampilkan estimasi biaya, kuota palsu, atau klaim akreditasi');
    }

    public function test_whatsapp_cta_prefills_specific_program_message(): void
    {
        config(['services.whatsapp.phone' => '089988776655']);

        $muda = $this->get(route('program.muda'));
        $muda->assertStatus(200);
        $mudaExpectedText = rawurlencode('Halo, saya ingin konsultasi mengenai jadwal, biaya, dan persyaratan pendaftaran Training K3 Konstruksi Muda.');
        $muda->assertSee('https://wa.me/6289988776655?text=' . $mudaExpectedText, false);

        $madya = $this->get(route('program.madya'));
        $madya->assertStatus(200);
        $madyaExpectedText = rawurlencode('Halo, saya ingin konsultasi mengenai jadwal, biaya, dan persyaratan pendaftaran Training K3 Konstruksi Madya.');
        $madya->assertSee('https://wa.me/6289988776655?text=' . $madyaExpectedText, false);

        $utama = $this->get(route('program.utama'));
        $utama->assertStatus(200);
        $utamaExpectedText = rawurlencode('Halo, saya ingin konsultasi mengenai jadwal, biaya, dan persyaratan pendaftaran Training K3 Konstruksi Utama.');
        $utama->assertSee('https://wa.me/6289988776655?text=' . $utamaExpectedText, false);
    }

    public function test_whatsapp_cta_falls_back_when_phone_is_empty(): void
    {
        config(['services.whatsapp.phone' => '']);

        $response = $this->get(route('program.muda'));
        $response->assertStatus(200);

        $expectedText = rawurlencode('Halo, saya ingin konsultasi mengenai jadwal, biaya, dan persyaratan pendaftaran Training K3 Konstruksi Muda.');
        $response->assertSee('https://wa.me/?text=' . $expectedText, false);
    }

    public function test_each_program_page_links_to_the_other_two_programs(): void
    {
        // Muda page should link to Madya and Utama
        $muda = $this->get(route('program.muda'));
        $muda->assertStatus(200);
        $muda->assertSee(route('program.madya'), false);
        $muda->assertSee(route('program.utama'), false);

        // Madya page should link to Muda and Utama
        $madya = $this->get(route('program.madya'));
        $madya->assertStatus(200);
        $madya->assertSee(route('program.muda'), false);
        $madya->assertSee(route('program.utama'), false);

        // Utama page should link to Muda and Madya
        $utama = $this->get(route('program.utama'));
        $utama->assertStatus(200);
        $utama->assertSee(route('program.muda'), false);
        $utama->assertSee(route('program.madya'), false);
    }

    public function test_program_pages_have_responsive_faq_section(): void
    {
        $response = $this->get(route('program.muda'));

        $response->assertStatus(200);
        $response->assertSee('<details', false);
        $response->assertSee('<summary', false);
        $response->assertSee('Pertanyaan Umum Seputar Training K3 Konstruksi Muda');
    }

    public function test_program_pages_have_no_p3k_or_invented_claims(): void
    {
        foreach ([route('program.muda'), route('program.madya'), route('program.utama')] as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);

            // No P3K contamination
            $response->assertDontSee('Pelatihan P3K');
            $response->assertDontSee('Kotak P3K');
            $response->assertDontSee('first aid', false);

            // No fabricated pass guarantees
            $response->assertDontSee('100% garansi lulus');
            $response->assertDontSee('pasti lulus');
            $response->assertDontSee('tanpa tes');
        }
    }

    public function test_homepage_and_footer_link_to_all_three_program_pages(): void
    {
        $home = $this->get(route('home'));

        $home->assertStatus(200);
        $home->assertSee(route('program.muda'), false);
        $home->assertSee(route('program.madya'), false);
        $home->assertSee(route('program.utama'), false);
    }
}

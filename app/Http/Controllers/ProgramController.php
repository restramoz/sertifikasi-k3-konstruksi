<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ProgramController extends Controller
{
    /**
     * Display the Training K3 Konstruksi Muda page.
     */
    public function muda(): View
    {
        return $this->show('k3-konstruksi-muda');
    }

    /**
     * Display the Training K3 Konstruksi Madya page.
     */
    public function madya(): View
    {
        return $this->show('k3-konstruksi-madya');
    }

    /**
     * Display the Training K3 Konstruksi Utama page.
     */
    public function utama(): View
    {
        return $this->show('k3-konstruksi-utama');
    }

    /**
     * Display a city‑specific program detail page.
     *
     * @param string $citySlug      Slug of the city/regency (e.g. "bandung")
     * @param string $programSlug   Program identifier ("muda", "madya", "utama")
     */
    public function cityProgram(string $city, string $program): View
    {
        // Resolve city via RegionalService (already type‑hinted in constructor if needed)
        $regional = app(\App\Services\RegionalService::class);
        $cityData = $regional->findCity($city);
        abort_if($cityData === null, 404, 'Kota/Kabupaten tidak ditemukan.');

        // Map program slug to the program config key used by existing show()
        $programMap = [
            'muda' => 'k3-konstruksi-muda',
            'madya' => 'k3-konstruksi-madya',
            'utama' => 'k3-konstruksi-utama',
            'k3-konstruksi-muda' => 'k3-konstruksi-muda',
            'k3-konstruksi-madya' => 'k3-konstruksi-madya',
            'k3-konstruksi-utama' => 'k3-konstruksi-utama',
        ];

        $configKey = $programMap[$program] ?? null;
        abort_if($configKey === null, 404, 'Program tidak ditemukan.');

        // Re‑use existing show logic to fetch program data
        $programs = config('programs', []);
        abort_if(! isset($programs[$configKey]), 404, 'Program tidak ditemukan.');
        $programData = $programs[$configKey];

        $otherPrograms = collect($programs)
            ->filter(fn (array $p, string $key): bool => $key !== $configKey)
            ->values()
            ->all();

        $waMessage = "Halo, saya dari {$cityData['name']} dan ingin konsultasi mengenai {$programData['title']}.";

        return view('city.program-detail', [
            'city' => $cityData,
            'program' => $programData,
            'otherPrograms' => $otherPrograms,
            'waMessage' => $waMessage,
        ]);
    }

    /**
     * Display the specified program page by slug.
     */
    public function show(string $slug): View
    {
        $programs = config('programs', []);

        if (!isset($programs[$slug])) {
            abort(404, 'Program tidak ditemukan.');
        }

        $program = $programs[$slug];

        $otherPrograms = collect($programs)
            ->filter(fn (array $p, string $key): bool => $key !== $slug)
            ->values()
            ->all();

        return view('programs.show', [
            'program' => $program,
            'otherPrograms' => $otherPrograms,
        ]);
    }
}

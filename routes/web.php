<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PublicArticleController;
use App\Http\Controllers\RegionalController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('program')->name('program.')->group(function () {
    Route::get('/k3-konstruksi-muda', [ProgramController::class, 'muda'])->name('muda');
    Route::get('/k3-konstruksi-madya', [ProgramController::class, 'madya'])->name('madya');
    Route::get('/k3-konstruksi-utama', [ProgramController::class, 'utama'])->name('utama');
});

// City-specific program detail pages preserving regional context
Route::get('kota/{city}/program/{program}', [ProgramController::class, 'cityProgram'])
    ->name('city.program.detail');

// Public Articles
Route::get('/artikel', [PublicArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [PublicArticleController::class, 'show'])->name('articles.show');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Panel Routes (Protected by Auth & Admin verification)
Route::middleware(['auth', EnsureUserIsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminArticleController::class, 'index'])->name('dashboard');
        Route::resource('articles', AdminArticleController::class)->except(['show']);
        Route::post('articles/ai-generate', [AdminArticleController::class, 'aiGenerate'])->name('articles.ai-generate');
        Route::post('upload-image', [AdminArticleController::class, 'uploadImage'])->name('upload.image');
    });

// Regional landing pages — slug-validated against BPS dataset, never arbitrary filesystem paths
Route::get('/provinsi/{slug}', [RegionalController::class, 'province'])
    ->name('regional.province')
    ->where('slug', '[a-z0-9\-]+');

Route::get('/kota/{slug}', [RegionalController::class, 'city'])
    ->name('regional.city')
    ->where('slug', '[a-z0-9\-]+');

// District pages are noindex (see regional/district.blade.php); include but keep separate
Route::get('/kecamatan/{citySlug}/{districtSlug}', [RegionalController::class, 'district'])
    ->name('regional.district')
    ->where(['citySlug' => '[a-z0-9\-]+', 'districtSlug' => '[a-z0-9\-]+']);

// Legacy compatibility redirects (from reference project URL structures)
Route::get('/kota-{slug}', [RegionalController::class, 'legacyCityRedirect'])
    ->name('city.landing')
    ->where('slug', '[a-z0-9\-]+');
Route::get('/pelatihan/kota-{slug}', [RegionalController::class, 'legacyCityRedirect'])
    ->where('slug', '[a-z0-9\-]+');
Route::get('/kota-{citySlug}/kecamatan-{districtSlug}', [RegionalController::class, 'legacyNestedDistrictRedirect'])
    ->name('district.show')
    ->where(['citySlug' => '[a-z0-9\-]+', 'districtSlug' => '[a-z0-9\-]+']);
Route::get('/kecamatan-{districtSlug}', [RegionalController::class, 'legacyDistrictRedirect'])
    ->name('kecamatan.landing')
    ->where('districtSlug', '[a-z0-9\-]+');
Route::get('/pelatihan/kecamatan-{districtSlug}', [RegionalController::class, 'legacyDistrictRedirect'])
    ->where('districtSlug', '[a-z0-9\-]+');
Route::get('/kecamatan/{districtSlug}', [RegionalController::class, 'legacyDistrictRedirect'])
    ->where('districtSlug', '[a-z0-9\-]+');



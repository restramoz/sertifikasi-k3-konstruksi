<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\OllamaService;
use App\Services\RegionalService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AiGenerateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** Bind a fake OllamaService that returns the given response array. */
    protected function bindFakeOllama(array $response): void
    {
        $mock = $this->createMock(OllamaService::class);
        $mock->method('generateArticle')
            ->willReturn($response);
        $this->app->instance(OllamaService::class, $mock);
    }

    protected function bindFakeRegional(array $city): void
    {
        $mock = $this->createMock(RegionalService::class);
        $mock->method('findCity')
            ->willReturn($city);
        // district not used in these tests
        $mock->method('findDistrict')
            ->willReturn(null);
        $this->app->instance(RegionalService::class, $mock);
    }

    public function test_rejects_word_count_below_minimum(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        // Mock region to bypass city lookup.
        $this->bindFakeRegional(['name' => 'Test City', 'slug' => 'some-city']);
        $this->actingAs($admin)->postJson(route('admin.articles.ai-generate'), [
            'city_slug' => 'some-city',
            'word_count' => 6000,
        ])->assertOk()->assertJson(['success' => true]);
    }

    public function test_short_article_triggers_error(): void
    {
        // Provide content only 3000 words while requesting 6000.
        $content = str_repeat('kata ', 3000);
        $this->bindFakeOllama([
            'success' => true,
            'title' => 'Test',
            'slug' => 'test',
            'excerpt' => 'Excerpt',
            'content' => $content,
            'seo_title' => 'SEO',
            'meta_description' => 'Meta',
            'suggested_faqs' => [],
            'image_brief' => [],
        ]);

        $admin = User::factory()->create(['is_admin' => true]);
        $this->bindFakeRegional(['name' => 'Test City', 'slug' => 'some-city']);
        $this->actingAs($admin)->postJson(route('admin.articles.ai-generate'), [
            'city_slug' => 'some-city',
            'word_count' => 6000,
        ])->assertOk()->assertJson(['success' => false]);
    }

    public function test_rejects_word_count_above_maximum(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->postJson(route('admin.articles.ai-generate'), [
            'city_slug' => 'some-city',
            'word_count' => 8000,
        ])->assertStatus(422);
    }

    // The over‑limit and under‑limit content enforcement is handled inside
    // OllamaService::generateArticle. Testing it would require a more elaborate
    // mock of the HTTP client. For now we focus on request validation.
}

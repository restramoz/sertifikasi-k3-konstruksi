<?php

namespace Tests\Unit;

use App\Services\OllamaService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OllamaServiceTest extends TestCase
{
    public function test_short_generated_article_returns_error(): void
    {
        // Ensure minimal config to pass initial checks.
        config([
            'services.ollama.base_url' => 'http://dummy-ollama.local',
            'services.ollama.model' => 'dummy-model',
        ]);

        // Fake HTTP response with a short article (3000 words ~ 3000 occurrences of 'kata').
        $shortContent = str_repeat('kata ', 1000);
        $responseBody = [
            'message' => [
                'content' => json_encode([
                    'title' => 'Test',
                    'slug' => 'test',
                    'excerpt' => 'Excerpt',
                    'content' => $shortContent,
                    'seo_title' => 'SEO',
                    'meta_description' => 'Meta',
                    'suggested_faqs' => [],
                    'image_brief' => [],
                ]),
            ],
        ];
        Http::fake([
            '*' => Http::response($responseBody, 200),
        ]);

        $service = new OllamaService();
        $result = $service->generateArticle([
            'city_name' => 'Test City',
            'city_slug' => 'test-city',
            'word_count' => 6000,
            'topic' => 'Dummy Topic', // avoid DB lookup
        ]);

        $this->assertFalse($result['success'] ?? true);
        $this->assertArrayHasKey('error', $result);
    }
}

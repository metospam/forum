<?php

namespace Tests\Feature;

use App\Models\Theme;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testHandleGetTopicsValidRequest(): void
    {
        Topic::query()->create(['icon' => '<span></span>', 'title' => 'Topic 1', 'slug' => 'topic_1']);
        $topic2 = Topic::query()->create(['icon' => '<svg></svg>', 'title' => 'Topic 2', 'slug' => 'topic_2']);

        $data = ['limit' => 1, 'offset' => 1];

        $response = $this->post('api/v1/topics', $data);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'icon' => '<svg></svg>',
                        'title' => $topic2->title,
                        'slug' => $topic2->slug,
                        'themes' => [],
                    ],
                ],
            ]);
    }

    public function testHandleGetTopicsNotValidRequest(): void
    {
        $data = ['limit' => 'limit', 'offset' => 1];

        $response = $this->post('api/v1/topics', $data);
        $response->assertStatus(400)
            ->assertJson(['limit' =>
                [
                    'The limit field must be an integer.',
                ]
            ]);
    }
}

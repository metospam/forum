<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\Impl\TimeServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function testHandleCreateCommentValidRequest(): void
    {
        $post = Post::query()->create([
            'image' => null,
            'title' => 'Post Title',
            'content' => fake()->text(10),
            'slug' => 'post_title',
            'user_id' => User::query()->first()->id,
        ]);

        $data = [
            'post_id' => $post->id,
            'content' => 'message',
        ];

        $response = $this->actingAs($this->user)->post('api/v1/comments/create', $data)
            ->assertStatus(201);

        $comment = Comment::query()->first();
        $response->assertJson([
            'data' => [
                'id' => $comment->id,
                'avatar' => $this->user->image,
                'username' => $this->user->username,
                'content' => $data['content'],
                'post_time' => '1 sec. ago',
                'children' => [],
            ],
        ]);

        $data['user_id'] = $this->user->id;

        $this->assertDatabaseHas('comments', $data);
    }

    public function testHandleCreateCommentNotValidRequest(): void
    {
        $data = [
            'post_id' => 1,
            'content' => 'message',
        ];

        $this->actingAs($this->user)->post('api/v1/comments/create', $data)
            ->assertStatus(400)
            ->assertJson([
                'post_id' => [
                    'The selected post id is invalid.'
                ],
            ]);

        $this->assertDatabaseMissing('comments', $data);
    }

    public function testHandleCreateCommentNotAuthorized(): void
    {
        $post = Post::query()->create([
            'image' => null,
            'title' => 'Post Title',
            'content' => fake()->text(10),
            'slug' => 'post_title',
            'user_id' => User::query()->first()->id,
        ]);

        $data = [
            'post_id' => $post->id,
            'content' => 'message',
        ];

        $this->post('api/v1/comments/create', $data)
            ->assertStatus(401);

        $data['user_id'] = $this->user->id;
        $this->assertDatabaseMissing('comments', $data);
    }
}

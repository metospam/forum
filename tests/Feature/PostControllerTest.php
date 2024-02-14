<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\Theme;
use App\Models\Topic;
use App\Models\User;
use App\Services\Impl\CommentServiceImpl;
use App\Services\Impl\TimeServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('post.jpg');

        $path = $image->getRealPath();
        $doc = file_get_contents($path);

        $this->imageBase64 = base64_encode($doc);

        $userData = [
            'username' => 'username',
            'email' => 'email@mail.ru',
            'password' => 'password',
        ];

        $this->user = User::query()->create($userData);
        $this->data = [
            'email' => 'email@mail.ru',
            'password' => 'password',
        ];

        Topic::factory()->create();
        Community::factory()->create();
        User::factory()->create();
        Theme::query()->create([
            'title' => fake()->word,
            'slug' => fake()->word,
            'topic_id' => Topic::query()->first()->id,
        ]);

        $this->commentService = app(CommentServiceImpl::class);
    }

    /**
     * A basic feature test example.
     */
    public function testHandleGetPostsValidRequest(): void
    {
        $themeId = Theme::query()->first()->id;
        $userId = User::query()->first()->id;
        $communityId = Community::query()->first()->id;

        Post::query()->create([
            'image' => null,
            'title' => 'Post 1',
            'content' => fake()->text(10),
            'slug' => 'post_1',
            'theme_id' => $themeId,
            'user_id' => $userId,
            'community_id' => $communityId,
        ]);

        $post2 = Post::query()->create([
            'image' => $this->imageBase64,
            'title' => 'Post 2',
            'content' => fake()->text(10),
            'slug' => 'post_2',
            'theme_id' => $themeId,
            'user_id' => $userId,
            'community_id' => $communityId,
        ]);

        $this->post('api/v1/posts', ['page' => 2, 'per_page' => 1])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $post2->id,
                        'image' => $post2->image,
                        'title' => $post2->title,
                        'content' => $post2->content,
                        'slug' => $post2->slug,
                        'time' => TimeServiceImpl::calculateCreatedAgoTime($post2->created_at),
                        'likes_count' => $post2->likesDiff(),
                        'comments_count' => $post2->comments->count(),
                    ],
                ],
                'last_page' => '2',
            ]);
    }

    public function testHandleGetPostsNotValidRequest(): void
    {
        $this->post('api/v1/posts', ['page' => '<script>test</script>', 'per_page' => 1])
            ->assertStatus(400)
            ->assertJson(['page' => ['The page field must be an integer.']]);
    }

    public function testHandleCreatePostValidRequest(): void
    {
        $data = [
            'image' => UploadedFile::fake()->image('post.jpg'),
            'title' => 'Post Title 1',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        ];
        $slug = Str::slug($data['title'], '_');

        $this->assertDatabaseMissing('posts', $data);

        $this->actingAs($this->user)->post('api/v1/posts/create', $data)
            ->assertStatus(200)
            ->assertJsonStructure(['slug'])
            ->assertJson(['slug' => $slug]);

        unset($data['image']);
        $data['slug'] = $slug;

        $imageBase64 = Post::query()->where('slug', $slug)->first()->image;

        $this->assertTrue(base64_encode(base64_decode($imageBase64, true)) === $imageBase64);
        $this->assertDatabaseHas('posts', $data);
    }

    public function testHandleCreatePostNotValidRequest(): void
    {
        $data = [
            'image' => UploadedFile::fake()->image('post.jpg'),
            'title' => 'Post Title 1',
            'content' => 'Lorem Ipsum.',
        ];

        $this->actingAs($this->user)->post('api/v1/posts/create', $data)
            ->assertStatus(400)
            ->assertJsonStructure(['content'])
            ->assertJson(['content' => ['The content field must be at least 20 characters.']]);

        $this->assertDatabaseMissing('posts', $data);
    }

    public function testHandleCreatePostNotAuthorized(): void
    {
        $data = [
            'image' => UploadedFile::fake()->image('post.jpg'),
            'title' => 'Post Title 1',
            'content' => 'Lorem Ipsum.',
        ];

        $this->post('api/v1/posts/create', $data)
            ->assertStatus(401);

        $this->assertDatabaseMissing('posts', $data);
    }

    public function testHandleSetLikeToPostFound(): void
    {
        $post = Post::factory()->create();
        $userId = User::query()->first()->id;

        $this->assertEquals(0, $post->likesDiff());

        $this->actingAs($this->user)->post('api/v1/posts/like/' . $post->id)
            ->assertStatus(200)
            ->assertJson(['likes_count' => $post->likesDiff()]);

        $this->assertEquals(1, $post->likesDiff());
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => true,
        ]);

        $this->actingAs($this->user)->post('api/v1/posts/like/' . $post->id)
            ->assertStatus(200)
            ->assertJson(['likes_count' => $post->likesDiff()]);

        $this->assertEquals(0, $post->likesDiff());
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => true,
        ]);

    }

    public function testHandleSetLikeToPostNotFound(): void
    {
        $post = Post::factory()->create();
        $userId = User::query()->first()->id;

        $this->actingAs($this->user)->post('api/v1/posts/like/' . 404)
            ->assertStatus(404);

        $this->assertEquals(0, $post->likesDiff());
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => true,
        ]);
    }

    public function testHandleSetLikeToPostNotAuthorized(): void
    {
        $post = Post::factory()->create();
        $userId = User::query()->first()->id;

        $this->post('api/v1/posts/like/' . 401)
            ->assertStatus(401);

        $this->assertEquals(0, $post->likesDiff());
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => true,
        ]);
    }

    public function testHandleSetDislikeToPostFound(): void
    {
        $post = Post::factory()->create();
        $userId = User::query()->first()->id;

        $this->assertEquals(0, $post->likesDiff());

        $this->actingAs($this->user)->post('api/v1/posts/dislike/' . $post->id)
            ->assertStatus(200)
            ->assertJson(['likes_count' => $post->likesDiff()]);

        $this->assertEquals(-1, $post->likesDiff());
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => false,
        ]);

        $this->actingAs($this->user)->post('api/v1/posts/dislike/' . $post->id)
            ->assertStatus(200)
            ->assertJson(['likes_count' => $post->likesDiff()]);

        $this->assertEquals(0, $post->likesDiff());
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => false,
        ]);
    }

    public function testHandleSetDislikeToPostNotFound(): void
    {
        $post = Post::factory()->create();
        $userId = User::query()->first()->id;

        $this->actingAs($this->user)->post('api/v1/posts/dislike/' . 404)
            ->assertStatus(404);

        $this->assertEquals(0, $post->likesDiff());
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => false,
        ]);
    }

    public function testHandleSetDislikeToPostNotAuthorized(): void
    {
        $post = Post::factory()->create();
        $userId = User::query()->first()->id;

        $this->post('api/v1/posts/dislike/' . 401)
            ->assertStatus(401);

        $this->assertEquals(0, $post->likesDiff());
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
            'user_id' => $userId,
            'is_like' => false,
        ]);
    }

    public function testHandleGetPost(): void
    {
        $post = Post::factory()->create();
        $comment1 = Comment::query()->create([
            'content' => fake()->text(10),
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'comment_id' => null,
        ]);
        $comment2 = Comment::query()->create([
            'content' => fake()->text(10),
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'comment_id' => $comment1->id,
        ]);
        $comment3 = Comment::query()->create([
            'content' => fake()->text(10),
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'comment_id' => $comment2->id,
        ]);

        $comment4 = Comment::query()->create([
            'content' => fake()->text(10),
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'comment_id' => $comment2->id,
        ]);

        $comment5 = Comment::query()->create([
            'content' => fake()->text(10),
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'comment_id' => $comment1->id,
        ]);

        $comment6 = Comment::query()->create([
            'content' => fake()->text(10),
            'user_id' => $this->user->id,
            'post_id' => $post->id,
            'comment_id' => null,
        ]);

        $timeDifference = TimeServiceImpl::calculateCreatedAgoTime($post->created_at);

        $response = $this->get('api/v1/posts/' . $post->slug)
            ->assertStatus(200);

        $expectedComments = [
            [
                'id' => $comment1->id,
                'avatar' => $this->user->image,
                'username' => $this->user->username,
                'post_time' => '',
                'content' => $comment1->content,
                'children' => [
                    [
                        'id' => $comment2->id,
                        'avatar' => $this->user->image,
                        'username' => $this->user->username,
                        'post_time' => '',
                        'content' => $comment2->content,
                        'children' => [
                            [
                                'id' => $comment3->id,
                                'avatar' => $this->user->image,
                                'username' => $this->user->username,
                                'post_time' => '',
                                'content' => $comment3->content,
                                'children' => [],
                            ],
                            [
                                'id' => $comment4->id,
                                'avatar' => $this->user->image,
                                'username' => $this->user->username,
                                'post_time' => '',
                                'content' => $comment4->content,
                                'children' => [],
                            ]
                        ],
                    ],
                    [
                        'id' => $comment5->id,
                        'avatar' => $this->user->image,
                        'username' => $this->user->username,
                        'post_time' => '',
                        'content' => $comment5->content,
                        'children' => [],
                    ]
                ],
            ],
            [
                'id' => $comment6->id,
                'avatar' => $this->user->image,
                'username' => $this->user->username,
                'post_time' => '',
                'content' => $comment6->content,
                'children' => [],
            ]
        ];

        $response->assertJson(['data' => [
            'id' => $post->id,
            'image' => $post->image,
            'title' => $post->title,
            'content' => $post->content,
            'time' => $timeDifference,
            'community' => null,
            'likes_count' => $post->likesDiff(),
            'comments_count' => $post->comments()->count(),
        ]]);

        $comments = $response->json('data')['comments'];
        $this->assertEquals($expectedComments, $comments);
    }

}

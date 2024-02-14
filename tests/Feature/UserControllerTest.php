<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Str;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->dataToCreateUser = [
            'image' => null,
            'username' => 'username',
            'email' => 'email@mail.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->user = User::query()->create($this->dataToCreateUser);

        $this->dataToUpdateUser = [
            'image' => UploadedFile::fake()->image('image.jpg'),
            'username' => 'updated_username',
            'email' => 'updated_email@mail.ru',
        ];
    }

    public function testHandleUpdateUserValidRequest(): void
    {
        $this->actingAs($this->user)->patch('api/v1/users', $this->dataToUpdateUser)
            ->assertStatus(200)
            ->assertJson([]);

        $this->user->refresh();

        $this->assertEquals([
            $this->dataToUpdateUser['username'],
            $this->dataToUpdateUser['email']
        ], [
            $this->user->username,
            $this->user->email
        ]);
    }

    public function testHandleUpdateUserNotValidRequest(): void
    {
        $data = [
            'username' => 'username',
            'email' => 'email',
        ];

        $this->actingAs($this->user)->patch('api/v1/users', $data)
            ->assertStatus(400)
            ->assertJson([
                'email' => [
                    'The email field must be a valid email address.',
                ]
            ]);

        $this->assertNotEquals([
            $this->dataToUpdateUser['username'],
            $this->dataToUpdateUser['email']
        ], [
            $this->user->username,
            $this->user->email
        ]);
    }

    public function testHandleUpdateUserNotAuthorized(): void
    {
        $data = [
            'username' => 'username',
            'email' => 'email',
        ];

        $this->patch('api/v1/users', $data)
            ->assertStatus(401);

        $this->assertNotEquals([
            $this->dataToUpdateUser['username'],
            $this->dataToUpdateUser['email']
        ], [
            $this->user->username,
            $this->user->email
        ]);
    }

    public function testHandleGetUserWithPostsValidRequest(): void
    {
        $data = [
            'page' => 2,
            'per_page' => 1,
        ];

        Post::query()->create([
            'image' => null,
            'title' => 'Post 1 title',
            'content' => fake()->text(10),
            'slug' => Str::slug('Post 1 title', '_'),
            'theme_id' => null,
            'community_id' => null,
            'user_id' => $this->user->id
        ]);

        $post2 = Post::query()->create([
            'image' => null,
            'title' => 'Post 2 title',
            'content' => fake()->text(10),
            'slug' => Str::slug('Post 2 title', '_'),
            'theme_id' => null,
            'community_id' => null,
            'user_id' => $this->user->id
        ]);


        $response = $this->post('api/v1/users/' . $this->user->username, $data)
            ->assertStatus(200)
            ->assertJsonStructure(['posts', 'user', 'last_page']);

        $postId = $response->json(['posts'])[0]['id'];
        $userId = $response->json(['user'])['username'];
        $lastPage = $response->json(['last_page']);

        $this->assertEquals($this->user->username, $userId);
        $this->assertEquals($post2->id, $postId);
        $this->assertEquals(2, $lastPage);
    }

    public function testHandleGetUserWithPostsNotValidRequest(): void
    {
        $data = [
            'page' => 'page',
            'per_page' => 1,
        ];

        $this->post('api/v1/users/' . $this->user->username, $data)
            ->assertStatus(400)
            ->assertJson(['page' =>
                [
                    'The page field must be an integer.',
                ]
            ]);
    }

    public function testHandleUploadAvatarToUserValidRequest(): void
    {
        $this->assertEquals($this->user->image, $this->dataToCreateUser['image']);
        $data = ['image' => $this->dataToUpdateUser['image']];

        $this->actingAs($this->user)->post('api/v1/users/avatar', $data)
            ->assertStatus(200);

        $this->user->refresh();
        $this->assertTrue(base64_encode(base64_decode($this->user->image, true)) === $this->user->image);
    }

    public function testHandleUploadAvatarToUserNotValidRequest(): void
    {
        $this->assertEquals($this->user->image, $this->dataToCreateUser['image']);
        $data = ['image' => 'test'];

        $this->actingAs($this->user)->post('api/v1/users/avatar', $data)
            ->assertStatus(400)
            ->assertJson(['image' =>
                [
                    'The image field must be an image.',
                    'The image field must be a file of type: jpeg, png, jpg.'
                ]
            ]);

        $this->user->refresh();
        $this->assertFalse(base64_encode(base64_decode($this->user->image, true)) === $this->user->image);
    }

    public function testHandleUploadAvatarToUserNotAuthorized(): void
    {
        $this->assertEquals($this->user->image, $this->dataToCreateUser['image']);
        $data = ['image' => $this->dataToUpdateUser['image']];

        $this->post('api/v1/users/avatar', $data)
            ->assertStatus(401);

        $this->user->refresh();
        $this->assertFalse(base64_encode(base64_decode($this->user->image, true)) === $this->user->image);
    }
}

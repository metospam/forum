<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Str;
use Tests\TestCase;

class CommunityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create([
            'image' => null,
            'username' => 'username',
            'email' => 'email@mail.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->apiUrl = 'api/v1/communities/';
    }

//    public function testHandleGetPopularCommunities(): void
//    {
//
//    }

    public function testHandleCreateCommunityValidAuthRequest(): void
    {
        $data = ['name' => 'Test Community'];
        $expectedData = ['name' => 'TestCommunity', 'slug' => 'testcommunity'];

        $this->actingAs($this->user)->post('api/v1/communities/create', $data)
            ->assertStatus(201)
            ->assertJson([
                'slug' => $expectedData['slug']
            ]);
        $this->assertDatabaseHas('communities', $expectedData);
    }

    public function testHandleCreateCommunityNotValidAuthRequest(): void
    {
        $data = ['name' => ''];

        $this->actingAs($this->user)->post('api/v1/communities/create', $data)
            ->assertStatus(400)
            ->assertJson(['name' =>
                ['The name field is required.'],
            ]);
    }

    public function testHandleCreateCommunityNotAuthorized(): void
    {
        $data = ['name' => 'Test Community'];
        $this->post('api/v1/communities/create', $data)
            ->assertStatus(401);

        $this->assertDatabaseMissing('communities', $data);
    }

    public function testHandleJoinTheCommunityFound(): void
    {
        $community = Community::factory()->create();
        $this->actingAs($this->user)->post('api/v1/communities/join/' . $community->id)
            ->assertStatus(200);

        $data = ['user_id' => $this->user->id, 'community_id' => $community->id, 'role' => 'member'];
        $this->assertDatabaseHas('users_communities', $data);
    }

    public function testHandleLeaveTheCommunityFound(): void
    {
        $community = Community::factory()->create();
        $this->user->communities()->attach($community->id);

        $data = ['user_id' => $this->user->id, 'community_id' => $community->id, 'role' => 'member'];
        $this->assertDatabaseHas('users_communities', $data);

        $this->actingAs($this->user)->post('api/v1/communities/leave/' . $community->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('users_communities', $data);
    }

    public function testHandleTheCommunityNotFound(): void
    {
        $this->actingAs($this->user)->post('api/v1/communities/leave/' . 404)
            ->assertStatus(404);

        $this->actingAs($this->user)->post('api/v1/communities/join/' . 404)
            ->assertStatus(404);
    }

    public function testHandleTheCommunityNotAuthorized(): void
    {
        $this->post('api/v1/communities/leave/' . 401)
            ->assertStatus(401);

        $this->post('api/v1/communities/join/' . 401)
            ->assertStatus(401);
    }

    public function testHandleGetUserWithPostsValidRequest(): void
    {
        $data = [
            'page' => 2,
            'per_page' => 1,
        ];

        $community = Community::factory()->create();

        Post::query()->create([
            'image' => null,
            'title' => 'Post 1 title',
            'content' => fake()->text(10),
            'slug' => Str::slug('Post 1 title', '_'),
            'theme_id' => null,
            'community_id' => $community->id,
            'user_id' => $this->user->id
        ]);

        $post2 = Post::query()->create([
            'image' => null,
            'title' => 'Post 2 title',
            'content' => fake()->text(10),
            'slug' => Str::slug('Post 2 title', '_'),
            'theme_id' => null,
            'community_id' => $community->id,
            'user_id' => $this->user->id
        ]);


        $response = $this->post('api/v1/communities/' . $community->slug, $data)
            ->assertStatus(200)
            ->assertJsonStructure(['community', 'posts', 'last_page']);

        $postId = $response->json(['posts'])[0]['id'];
        $userId = $response->json(['community'])['slug'];
        $lastPage = $response->json(['last_page']);

        $this->assertEquals($community->slug, $userId);
        $this->assertEquals($post2->id, $postId);
        $this->assertEquals(2, $lastPage);
    }

    public function testHandleGetUserWithPostsNotValidRequest(): void
    {
        $data = [
            'page' => 'string',
            'per_page' => 1,
        ];

        $community = Community::factory()->create();

        $this->post('api/v1/communities/' . $community->slug, $data)
            ->assertStatus(400)
            ->assertJson(['page' =>
                [
                    'The page field must be an integer.'
                ]
            ]);
    }

    public function testHandleUpdateCommunityAuthorizedWithAccessValidRequest(): void
    {
        $name = fake()->word;
        $slug = Str::slug($name, '_');

        $community = Community::query()->create([
            'image' => null,
            'name' => $name,
            'slug' => $slug,
            'description' => 'not updated description',
        ]);

        $community->users()->attach($this->user->id, ['role' => 'admin']);

        $data = ['description' => 'updated description'];

        $this->actingAs($this->user)->patch('api/v1/communities/update/' . $community->slug, $data)
            ->assertStatus(200);

        $community->refresh();
        $this->assertEquals($data['description'], $community->description);
    }

    public function testHandleUpdateCommunityAuthorizedWithoutAccessValidRequest(): void
    {
        $name = fake()->word;
        $slug = Str::slug($name, '_');

        $community = Community::query()->create([
            'image' => null,
            'name' => $name,
            'slug' => $slug,
            'description' => 'not updated description',
        ]);

        $data = ['description' => 'updated description'];

        $this->actingAs($this->user)->patch('api/v1/communities/update/' . $community->slug, $data)
            ->assertStatus(403);

        $community->refresh();
        $this->assertNotEquals($data['description'], $community->description);
    }

    public function testHandleUpdateCommunityNotAuthorized(): void
    {
        $name = fake()->word;
        $slug = Str::slug($name, '_');

        $community = Community::query()->create([
            'image' => null,
            'name' => $name,
            'slug' => $slug,
            'description' => 'not updated description',
        ]);

        $data = ['description' => 'updated description'];

        $this->patch('api/v1/communities/update/' . $community->slug, $data)
            ->assertStatus(401);

        $community->refresh();
        $this->assertNotEquals($data['description'], $community->description);
    }

    public function testHandleUpdateCommunityAuthorizedNotValidRequest(): void
    {
        $name = fake()->word;
        $slug = Str::slug($name, '_');

        $community = Community::query()->create([
            'image' => null,
            'name' => $name,
            'slug' => $slug,
            'description' => 'not updated description',
        ]);

        $data = ['description' => Str::random(301)];

        $this->actingAs($this->user)->patch('api/v1/communities/update/' . $community->slug, $data)
            ->assertStatus(400)
            ->assertJson(['description' =>
                [
                    'The description field must not be greater than 300 characters.',
                ]
            ]);

        $community->refresh();
        $this->assertNotEquals($data['description'], $community->description);
    }

    public function testHandleUploadAvatarToCommunityAuthorizedWithAccessValidRequest(): void
    {
        $community = Community::factory()->create();
        $community->users()->attach($this->user->id, ['role' => 'moderator']);

        $data = ['image' => UploadedFile::fake()->image('image.jpg')];

        $this->actingAs($this->user)->post('api/v1/communities/avatar/' . $community->slug, $data)
            ->assertStatus(200);

        $community->refresh();
        $this->assertTrue(base64_encode(base64_decode($community->image, true)) === $community->image);
    }

    public function testHandleUploadAvatarToCommunityAuthorizedWithoutAccessValidRequest(): void
    {
        $community = Community::factory()->create();
        $data = ['image' => UploadedFile::fake()->image('image.jpg')];

        $this->actingAs($this->user)->post('api/v1/communities/avatar/' . $community->slug, $data)
            ->assertStatus(403);

        $community->refresh();
        $this->assertFalse(base64_encode(base64_decode($community->image, true)) === $community->image);
    }

    public function testHandleUploadAvatarToCommunityNotAuthorized(): void
    {
        $community = Community::factory()->create();
        $data = ['image' => UploadedFile::fake()->image('image.jpg')];

        $this->post('api/v1/communities/avatar/' . $community->slug, $data)
            ->assertStatus(401);

        $community->refresh();
        $this->assertFalse(base64_encode(base64_decode($community->image, true)) === $community->image);
    }

    public function testHandleUploadAvatarToCommunityAuthorizedNotValidRequest(): void
    {
        $community = Community::factory()->create();
        $data = ['image' => 'string'];

        $this->actingAs($this->user)->post('api/v1/communities/avatar/' . $community->slug, $data)
            ->assertStatus(400)
            ->assertJson(['image' =>
                [
                    'The image field must be an image.',
                    'The image field must be a file of type: jpeg, png, jpg.'
                ]
            ]);

        $community->refresh();
        $this->assertFalse(base64_encode(base64_decode($community->image, true)) === $community->image);
    }

    public function testHandleGetCommunity(): void
    {
        $community = Community::factory()->create();

        $this->get($this->apiUrl . $community->slug)
            ->assertStatus(200)
            ->assertJson(['data' =>
                [
                    'id' => $community->id,
                    'image' => $community->image,
                    'name' => $community->name,
                    'slug' => $community->slug,
                    'description' => $community->description,
                    'members' => $community->users()->count(),
                    'moderators' => $community->moderators()->pluck('user_id')->toArray(),
                    'admins' => $community->administrators()->pluck('user_id')->toArray(),
                    'created_at' => $community->created_at->format('M d, Y'),
                ]
            ]);
    }

    public function testHandleGetCommunityNoFound(): void
    {
        $this->get($this->apiUrl . 404)
            ->assertStatus(404);
    }
}

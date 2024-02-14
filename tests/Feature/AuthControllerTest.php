<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

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
    }

    public function testHandleAuthUserValidRequest(): void
    {
        $response = $this->post('api/v1/auth/login', $this->data);
        $response->assertStatus(200)
            ->assertJson([
                'access_token' => $response['access_token'],
                'token_type' => 'bearer',
                'expires_in' => 3600,
            ]);
    }

    public function testHandleAuthUserNotValidRequest(): void
    {
        $data = [
            'email' => 'emailmail.ru',
            'password' => 'password',
        ];

        $this->post('api/v1/auth/login', $data)
            ->assertStatus(400)
            ->assertJson([
                'email' => [
                    'The email field must be a valid email address.',
                ]
            ]);
    }

    public function testHandleRefreshToken(): void
    {
        $headers = [
            'Authorization' => auth()->attempt($this->data),
        ];

        $response = $this->post('api/v1/auth/refresh', [], $headers);

        $response->assertStatus(200)
            ->assertJson([
                'access_token' => $response['access_token'],
                'token_type' => 'bearer',
                'expires_in' => 3600,
            ]);
    }

    public function testHandleRefreshTokenNotAuthorized(): void
    {
        $response = $this->post('api/v1/auth/refresh');
        $response->assertStatus(401);
    }

    public function testHandleGetUser(): void
    {
        $headers = [
            'Authorization' => auth()->attempt($this->data),
        ];

        $user = User::query()->where('email', $this->data['email'])->first();

        $this->post('api/v1/auth/data', [], $headers)
            ->assertStatus(200)
            ->assertJson(['data' => [
                'id' => $user->id,
                'image' => $user->image,
                'username' => $user->username,
                'email' => $user->email,
                'communities' => $user->communities()->pluck('community_id')->toArray(),
                'likes' => $user->likesForPosts()->pluck('likeable_id')->toArray(),
                'dislikes' => $user->dislikesForPosts()->pluck('likeable_id')->toArray(),
                'registered' => $user->created_at->format('M d, Y'),
            ]
        ]);
    }

    public function testHandleGetUserNotAuthorized(): void
    {
        $this->post('api/v1/auth/data')
            ->assertStatus(401);
    }

    public function testHandleLogoutUser(): void
    {
        $headers = [
            'Authorization' => auth()->attempt($this->data),
        ];

        $this->post('api/v1/auth/logout', [], $headers)
            ->assertStatus(200);
    }

    public function testHandleLogoutUserNotAuthorized(): void
    {
        $this->post('api/v1/auth/logout')
            ->assertStatus(401);
    }

    public function testHandleRegisterUserValidRequest(): void
    {
        $data = [
            'username' => 'new_username',
            'email' => 'new_email@mail.ru',
        ];

        $request = [
            'username' => 'new_ username',
            'email' => 'new_email@mail.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->assertDatabaseMissing('users', $data);

        $response = $this->post('api/v1/auth/register', $request)
            ->assertStatus(201);

        $this->assertIsString($response->json(['access_token']));
        $this->assertDatabaseHas('users', $data);
    }

    public function testHandleRegisterUserNotValidRequest(): void
    {
        $data = [
            'username' => 'username',
            'email' => 'email',
        ];

        $request = [
            'username' => 'username',
            'email' => 'email',
            'password' => 'password',
            'password_confirmation' => 'incorrect_password',
        ];

        $response = $this->post('api/v1/auth/register', $request);

        $response->assertStatus(400)
            ->assertJsonStructure(['password'])
            ->assertJson([
                'password' => [
                    'The password field confirmation does not match.',
                ]
            ]);

        $this->assertDatabaseMissing('users', $data);
    }
}

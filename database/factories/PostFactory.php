<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->text(50);
        $slug = Str::slug($title, '_');

        return [
            'image' => null,
            'title' => $title,
            'content' => fake()->text(400),
            'slug' => $slug,
            'user_id' => User::query()->first()->id,
        ];
    }
}

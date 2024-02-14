<?php

namespace Database\Factories;

use App\Models\Community;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word;
        $slug = Str::slug($name, '_');

        return [
            'image' => null,
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->text(10),
        ];
    }
}

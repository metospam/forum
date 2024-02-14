<?php

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = fake()->text(20);

        Community::query()->create([
            'image' => null,
            'name' => $name,
            'slug' => Str::slug($name, '_'),
            'description' => fake()->text(500),
        ]);
    }
}

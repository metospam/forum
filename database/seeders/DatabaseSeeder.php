<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);
        $this->call(CommunitySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
    }
}

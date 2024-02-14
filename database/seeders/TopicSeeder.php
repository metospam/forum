<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create gaming topic
        $gamingTopic = Topic::query()->create(['icon' => '
        <svg rpl="" fill="currentColor" height="20" icon-name="topic-videogaming-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="M19.929 14.17 18.277 6.6a4.631 4.631 0 0 0-4.52-3.6H5.702a4.623 4.623 0 0 0-4.58 3.908L.034 14.387a3.134 3.134 0 0 0 .735 2.5 3.227 3.227 0 0 0 5.553-1.284l.39-1.635h5.794l.39 1.635A3.2 3.2 0 0 0 16.01 18h.782a3.211 3.211 0 0 0 3.123-2.444c.109-.455.114-.929.015-1.386Zm-1.6 1.85a1.964 1.964 0 0 1-1.54.73h-.781a1.947 1.947 0 0 1-1.9-1.453l-.63-2.476H5.74L5.11 15.3a1.947 1.947 0 0 1-1.9 1.453 1.974 1.974 0 0 1-1.5-.678 1.862 1.862 0 0 1-.443-1.506l1.09-7.481A3.366 3.366 0 0 1 5.7 4.25h8.062a3.373 3.373 0 0 1 3.3 2.614l1.65 7.573a1.877 1.877 0 0 1-.383 1.583h-.001Z"></path><path d="M6.256 6.212h-1.25v1.776h-1.73v1.25h1.73v1.622h1.25V9.238h1.73v-1.25h-1.73V6.212Z"></path><path d="M11.82 8.81a1 1 0 1 0 1.71.71 1.001 1.001 0 0 0-.3-.71 1.034 1.034 0 0 0-1.41 0Z"></path><path d="M15.23 6.85a.875.875 0 0 0-.32-.22c-.246-.1-.522-.1-.77 0a.875.875 0 0 0-.32.22.975.975 0 0 0 0 1.41 1 1 0 0 0 1.41 0 1.03 1.03 0 0 0 .22-1.09.877.877 0 0 0-.22-.32Z"></path>
        </svg>', 'title' => 'Gaming', 'slug' => 'gaming']);

        // Create gaming themes
        Theme::query()->create(['title' => 'Valheim', 'slug' => 'valheim', 'topic_id' => $gamingTopic->id]);
        Theme::query()->create(['title' => 'Minecraft', 'slug' => 'minecraft', 'topic_id' => $gamingTopic->id]);
        Theme::query()->create(['title' => 'Genshin Impact', 'slug' => 'genshin_impact', 'topic_id' => $gamingTopic->id]);
        Theme::query()->create(['title' => 'Pokimane', 'slug' => 'pokimane', 'topic_id' => $gamingTopic->id]);
        Theme::query()->create(['title' => 'Halo Infinite', 'slug' => 'halo_infinite', 'topic_id' => $gamingTopic->id]);
        Theme::query()->create(['title' => 'Path of Exile', 'slug' => 'path_of_exile', 'topic_id' => $gamingTopic->id]);

        $sportsTopic = Topic::query()->create(['icon' => '
        <svg rpl="" fill="currentColor" height="20" icon-name="topic-sports-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0ZM4.124 16.465l1.259-3.007a9.906 9.906 0 0 0 .261-6.964l-1.186.4a8.656 8.656 0 0 1-.228 6.087l-1.046 2.5a8.75 8.75 0 1 1 13.632 0l-1.046-2.5a8.653 8.653 0 0 1-.228-6.086l-1.186-.4a9.906 9.906 0 0 0 .261 6.964l1.259 3.007a8.7 8.7 0 0 1-11.752-.001Z"></path>
        </svg>', 'title' => 'Sports', 'slug' => 'sports']);

        $businessTopic = Topic::query()->create(['icon' => '
        <svg rpl="" fill="currentColor" height="20" icon-name="topic-business-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.25 19H1v-4.5h1.25V19Zm4-7H5v7h1.25v-7Zm8 0H13v7h1.25v-7Zm4-5H17v12h1.25V7ZM6 7.557l3.206 3.2a1.126 1.126 0 0 0 1.59 0l8.647-8.646-.884-.884L10 9.79l-3.2-3.2a1.153 1.153 0 0 0-1.59 0L.559 11.231l.884.884L6 7.557Zm4.25 6.943H9V19h1.25v-4.5Z"></path>
        </svg>', 'title' => 'Business', 'slug' => 'business']);

        $cryptoTopic = Topic::query()->create(['icon' => '
        <svg rpl="" fill="currentColor" height="20" icon-name="topic-crypto-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="M11.66 14H8.34a1.126 1.126 0 0 1-.974-.562l-1.8-3.125a.623.623 0 0 1 0-.625l1.8-3.125A1.125 1.125 0 0 1 8.34 6h3.32a1.125 1.125 0 0 1 .974.563l1.8 3.125a.623.623 0 0 1 0 .625l-1.8 3.125a1.127 1.127 0 0 1-.974.562Zm-3.247-1.25h3.174L13.175 10l-1.588-2.75H8.413L6.825 10l1.588 2.75Zm-3.93-4.312 1.443-2.5a1.13 1.13 0 0 0 0-1.125l-1.9-3.292-1.083.625 1.864 3.229-1.37 2.375H.4V9h3.1a1.126 1.126 0 0 0 .982-.562Zm1.443 6.75a1.13 1.13 0 0 0 0-1.125l-1.444-2.5A1.125 1.125 0 0 0 3.508 11H.4v1.25h3.036l1.371 2.375-1.864 3.229 1.083.625 1.9-3.291ZM19.6 7.75h-3.036l-1.37-2.375 1.863-3.229-1.083-.625-1.9 3.292a1.13 1.13 0 0 0 0 1.125l1.444 2.5a1.126 1.126 0 0 0 .974.562h3.1l.008-1.25Zm-2.539 10.1-1.864-3.229 1.371-2.375H19.6V11h-3.1a1.125 1.125 0 0 0-.974.563l-1.444 2.5a1.13 1.13 0 0 0 0 1.125l1.9 3.291 1.08-.629Z"></path>
        </svg>', 'title' => 'Crypto', 'slug' => 'crypto']);
    }
}

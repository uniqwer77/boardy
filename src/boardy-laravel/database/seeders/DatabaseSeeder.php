<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@boardy.local',
            'password' => '123456',
        ]);

        $users = User::factory()->count(4)->create();

        $posts = Post::factory()->count(10)->create([ 
            'user_id' => fn() => $users->random()->id, 
        ]);

        Comment::factory()->count(25)->create([ 
            'post_id' => fn() => $posts->random()->id, 
            'user_id' => fn() => $users->random()->id, 
        ]);
    }
}

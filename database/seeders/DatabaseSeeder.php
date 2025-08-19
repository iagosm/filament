<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $tags = Tag::factory(10)->create();
        $categories = Category::factory(30)->create();
        $posts = Post::factory(10)
        ->recycle($users)
        ->recycle($tags)
        ->recycle($categories)
        ->create();
        $comments = Comment::factory(10)->recycle($posts)->create();
        Reply::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

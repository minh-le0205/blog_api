<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 1 user nếu chưa có
        $user = User::first() ?? User::factory()->create();

        // Tạo categories
        Category::factory(5)->create();

        // Tạo tags
        Tag::factory(10)->create();

        // Tạo bài viết và gán tag
        Post::factory(20)->create([
            'user_id' => $user->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ])->each(function ($post) {
            $tags = Tag::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $post->tags()->attach($tags);
        });
    }
}
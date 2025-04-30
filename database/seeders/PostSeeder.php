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
        // 1. Tạo sẵn 4 users
        $users = User::factory(4)->create();

        // 2. Tạo 5 categories
        Category::factory(5)->create();

        // 3. Tạo 10 tags
        Tag::factory(10)->create();

        // 4. Tạo 20 bài viết
        Post::factory(20)->make()->each(function ($post) use ($users) {
            // Gán user ngẫu nhiên
            $post->user_id = $users->random()->id;

            // Gán category ngẫu nhiên
            $post->category_id = Category::inRandomOrder()->first()->id;

            // Lưu bài viết vào DB
            $post->save();

            // Gắn tag ngẫu nhiên
            $tags = Tag::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $post->tags()->attach($tags);
        });
    }
}
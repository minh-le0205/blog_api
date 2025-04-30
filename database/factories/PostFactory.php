<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

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
        return [
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(5),
            'user_id' => User::factory(), // hoặc gán tay nếu đã có user
            'category_id' => Category::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
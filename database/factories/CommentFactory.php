<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(),
			'statistics' => [
				'likes' => [],
				'deslikes' => []
			],
			'post_id' => fake()->numberBetween(1, 10),
			'user_id' => fake()->numberBetween(1, 10)
        ];
    }
}

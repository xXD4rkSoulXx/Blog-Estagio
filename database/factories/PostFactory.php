<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

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
			'text' => fake()->text(),
			'wallpaper' => 'storage/post_wallpapers/factory.png',
			'statistics' => [
				'likes' => [],
				'deslikes' => [], 
				'views' => 0
			],
			'user_id' => fake()->numberBetween(1, 10)
        ];
    }
	
	public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $tags = Tag::inRandomOrder()->take(rand(1, 10))->pluck('id');
            $post->tags()->attach($tags);
        });
    }
}

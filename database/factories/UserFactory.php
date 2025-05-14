<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$nick = fake()->unique()->userName();
		
        return [
            'name' => fake()->name(),
			'nick' => $nick,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
			'photo' => 'storage/profile_photos/default.png',
			'wallpaper' => 'storage/profile_wallpapers/default.png',
			'birth' => fake()->dateTime(),
			'follows' => [
				'following' => [],
				'followers' => []
			],
			'bio' => fake()->text(),
			'facebook' => 'https://www.facebook.com/' . $nick,
			'instagram' => 'https://www.instagram.com/' . $nick,
			'twitter' => 'https://www.x.com/' . $nick,
			'youtube' => 'https://www.youtube.com/' . $nick,
			'github' => 'https://www.github.com/' . $nick,
			'linkedin' => 'https://www.linkedin.com/' . $nick,
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

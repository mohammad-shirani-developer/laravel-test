<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Arr;
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
        return [
            'name' => fake()->name(),
            'type' => Arr::random(['admin','user']),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make(12345),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's type address should be user.
     */
    public function user()
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'user',
        ]);
    }
    /**
     * Indicate that the model's type address should be admin.
     */
    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'admin',
        ]);
    }
}

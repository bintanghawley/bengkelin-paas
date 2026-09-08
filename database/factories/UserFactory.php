<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nomor_telepon' => '08' . fake()->unique()->numerify('##########'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'mekanik', 'pengguna']),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => []);
    }
}

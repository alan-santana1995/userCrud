<?php

namespace Database\Factories;

use App\Domain\User\Enum\UfEnum;
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
        return [
            'name' => fake()->firstName(),
            'last_name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'document' => fake()->regexify('\d{11}'),
            'birth_date' => fake()->date(),
            'phone_number' => fake()->regexify('\d{11}'),
            'zip_code' => fake()->regexify('\d{7}'),
            'uf' => fake()->randomElement(UfEnum::valuesToArray()),
            'city' => fake()->name(),
            'neighborhood' => fake()->name(),
            'address' => fake()->name(),
            'status' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => false,
        ]);
    }
}

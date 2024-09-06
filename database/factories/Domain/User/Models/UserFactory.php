<?php

namespace Database\Factories\Domain\User\Models;

use App\Domain\User\Enum\UfEnum;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'document' => fake()->regexify('\d{11}'),
            'birth_date' => fake()->date(),
            'phone_number' => fake()->regexify('\d{10}'),
            'zip_code' => fake()->regexify('\d{8}'),
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

    public function randomStatus(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => fake()->randomElement([true, false]),
        ]);
    }
}

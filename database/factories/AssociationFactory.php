<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AssociationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'                => $this->faker->company,
            'registration_number' => $this->faker->unique()->numerify('REG-####'),
            'address'             => $this->faker->address,
            'phone'               => $this->faker->phoneNumber,
            'email'               => $this->faker->unique()->safeEmail,
            'status'              => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}

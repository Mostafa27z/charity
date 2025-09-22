<?php

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\Association;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeneficiaryFactory extends Factory
{
    protected $model = Beneficiary::class;

    public function definition(): array
    {
        return [
            'national_id'  => $this->faker->unique()->numerify('###########'),
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'gender'       => $this->faker->randomElement(['male', 'female']),
            'birth_date'   => $this->faker->date(),
            'phone'        => $this->faker->phoneNumber,
            'address'      => $this->faker->address,
            'family_size'  => $this->faker->numberBetween(1, 10),
            'income'       => $this->faker->randomFloat(2, 0, 10000),
            'notes'        => $this->faker->sentence,

            // ✅ Automatically create or associate an existing association
            'association_id' => Association::factory(),
        ];
    }
}

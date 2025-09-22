<?php

namespace Database\Factories;

use App\Models\Aid;
use App\Models\Association;
use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AidFactory extends Factory
{
    protected $model = Aid::class;

    public function definition(): array
    {
        return [
            'beneficiary_id' => Beneficiary::factory(),
            'association_id' => Association::factory(),
            'aid_type'       => $this->faker->randomElement([
                'financial','food','medical','education','clothing','other'
            ]),
            'amount'         => $this->faker->optional()->randomFloat(2, 10, 5000),
            'description'    => $this->faker->sentence(),
            'aid_date'       => $this->faker->date(),
            'created_by'     => User::factory(),
        ];
    }
}

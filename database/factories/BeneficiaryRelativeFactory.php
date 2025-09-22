<?php

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\BeneficiaryRelative;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeneficiaryRelativeFactory extends Factory
{
    protected $model = BeneficiaryRelative::class;

    public function definition(): array
    {
        return [
            'beneficiary_id' => Beneficiary::factory(), // يعمل مستفيد لو مش موجود
            'name'           => $this->faker->name,
            'national_id'    => $this->faker->unique()->numerify('###########'),
            'gender'         => $this->faker->randomElement(['male', 'female']),
            'birth_date'     => $this->faker->date(),
            'phone'          => $this->faker->phoneNumber,
            'relation_type'  => $this->faker->randomElement(['زوجة', 'ابن', 'ابنة', 'أخ', 'أخت']),
            'notes'          => $this->faker->sentence,
        ];
    }
}

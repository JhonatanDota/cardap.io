<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id'     => User::factory(),
            'name'         => $this->faker->company(),
            'email'        => $this->faker->unique()->companyEmail(),
            'phone'        => $this->faker->numerify('###########'),
            'street'       => $this->faker->streetName(),
            'number'       => $this->faker->buildingNumber(),
            'complement'   => $this->faker->optional()->secondaryAddress(),
            'neighborhood' => $this->faker->streetSuffix(),
            'city'         => $this->faker->city(),
            'postal_code'  => $this->faker->numerify('########'),
            'state'        => $this->faker->stateAbbr(),
        ];
    }
}

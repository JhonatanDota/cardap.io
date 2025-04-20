<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Enums\Address\StatesEnum;

use App\Models\User;

use App\Rules\Fields\Commom\CnpjRules;
use App\Rules\Fields\Commom\PhoneRules;
use App\Rules\Fields\Address\PostalCodeRules;

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
            'cnpj'         => $this->faker->numerify(str_repeat('#', CnpjRules::LENGTH)),
            'email'        => $this->faker->unique()->companyEmail(),
            'phone'        => $this->faker->numerify(str_repeat('#', PhoneRules::LENGTH)),
            'street'       => $this->faker->streetName(),
            'number'       => $this->faker->buildingNumber(),
            'complement'   => $this->faker->optional()->secondaryAddress(),
            'neighborhood' => $this->faker->streetSuffix(),
            'city'         => $this->faker->city(),
            'postal_code'  => $this->faker->numerify(str_repeat('#', PostalCodeRules::LENGTH)),
            'state'        => $this->faker->randomElement(StatesEnum::values()),
        ];
    }
}

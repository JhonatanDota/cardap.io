<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Enums\Date\WeekDaysEnum;

use App\Models\Company;

class CompanyOpeningHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'week_day' => $this->faker->randomElement(WeekDaysEnum::cases()),
            'open_hour' => $this->faker->time('H:i'),
            'close_hour' => $this->faker->time('H:i'),
        ];
    }
}

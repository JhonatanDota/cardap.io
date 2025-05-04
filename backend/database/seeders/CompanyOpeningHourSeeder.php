<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\CompanyOpeningHour;

class CompanyOpeningHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyOpeningHour::factory(10)->create();
    }
}

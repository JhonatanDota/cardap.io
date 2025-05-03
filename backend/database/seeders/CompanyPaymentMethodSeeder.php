<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\CompanyPaymentMethod;

class CompanyPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyPaymentMethod::factory(10)->create();
    }
}

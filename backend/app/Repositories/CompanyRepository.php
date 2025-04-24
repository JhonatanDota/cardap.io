<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    /**
     * Create Company.
     *
     * @param array $inputs
     * @return Company
     */
    public function create(array $inputs): Company
    {
        return Company::create($inputs);
    }
}

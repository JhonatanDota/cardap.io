<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    /**
     * Create Company.
     *
     * @param array $data
     * @return Company
     */
    public function create(array $data): Company
    {
        return Company::create($data);
    }

    /**
     * Update Company.
     *
     * @param Company $company
     * @param array $data
     * @return Company
     */
    public function update(Company $company, array $data): Company
    {
        $company->update($data);

        return $company->refresh();
    }
}

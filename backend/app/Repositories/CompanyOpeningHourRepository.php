<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

use App\Models\Company;

class CompanyOpeningHourRepository
{
    /**
     * Get company opening hours.
     *
     * @param Company $company
     * @return Collection
     */
    public function fromCompany(Company $company): Collection
    {
        return $company->openingHours;
    }
}

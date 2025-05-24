<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

use App\Models\Company;
use App\Models\CompanyOpeningHour;

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

    /**
     * Sync company opening hours.
     * 
     * @param Company $company
     * @param array $openingHours
     * @return Collection
     */
    public function sync(Company $company, array $openingHours): Collection
    {
        $company->openingHours()->delete();

        $syncedOpeningHours = array_map(function ($openingHour) use ($company) {
            return array_merge(
                ['company_id' => $company->id],
                $openingHour
            );
        }, $openingHours);

        CompanyOpeningHour::insert($syncedOpeningHours);

        return $company->openingHours;
    }
}

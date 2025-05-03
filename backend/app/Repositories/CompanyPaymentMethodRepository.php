<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

use App\Models\Company;
use App\Models\CompanyPaymentMethod;

class CompanyPaymentMethodRepository
{
    /**
     * Get company payment methods.
     *
     * @param Company $company
     * @return Collection
     */
    public function fromCompany(Company $company): Collection
    {
        return $company->paymentMethods;
    }

    /**
     * Sync company payment methods.
     * 
     * @param Company $company
     * @param array $paymentMethods
     * @return Collection
     */
    public function sync(Company $company, array $paymentMethods): Collection
    {
        $syncedPaymentMethods = [];

        $company->paymentMethods()->delete();

        foreach ($paymentMethods as $paymentMethod) {
            $syncedPaymentMethods[] = [
                'company_id' => $company->id,
                'payment_method' => $paymentMethod,
            ];
        }

        CompanyPaymentMethod::insert($syncedPaymentMethods);

        return $company->paymentMethods;
    }
}

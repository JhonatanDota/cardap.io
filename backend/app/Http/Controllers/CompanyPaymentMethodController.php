<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use App\Repositories\CompanyPaymentMethodRepository as Repository;

use App\Models\Company;

use App\Http\Requests\CompanyPaymentMethod\SyncCompanyPaymentMethod;

class CompanyPaymentMethodController extends Controller
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get company payment methods.
     * 
     * @param Company $company
     * @return JsonResponse
     */

    public function show(Company $company): JsonResponse
    {
        $paymentMethods = $this->repository->fromCompany($company);

        return response()->json($paymentMethods);
    }

    /**
     * Sync company payment methods.
     * 
     * @param Company $company
     * @param SyncCompanyPaymentMethod $request
     * @return JsonResponse
     */

    public function sync(Company $company, SyncCompanyPaymentMethod $request): JsonResponse
    {
        $methods = $request->validated()['methods'];
        $paymentMethods = $this->repository->sync($company, $methods);

        return response()->json($paymentMethods);
    }
}

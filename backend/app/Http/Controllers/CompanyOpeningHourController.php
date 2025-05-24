<?php

namespace App\Http\Controllers;

use App\Models\Company;

use App\Repositories\CompanyOpeningHourRepository;

use App\Http\Requests\CompanyOpeningHour\SyncCompanyOpeningHourRequest;

class CompanyOpeningHourController extends Controller
{
    private CompanyOpeningHourRepository $companyOpeningHourRepository;

    public function __construct(CompanyOpeningHourRepository $companyOpeningHourRepository)
    {
        $this->companyOpeningHourRepository = $companyOpeningHourRepository;
    }

    /**
     * Show the opening hours of a company.
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function show(Company $company)
    {
        $openingHours = $this->companyOpeningHourRepository->fromCompany($company);

        return response()->json($openingHours);
    }

    /**
     * Sync the opening hours of a company.
     *
     * @param Company $company
     * @param SyncCompanyOpeningHourRequest $request
     * @return JsonResponse
     */
    public function sync(Company $company, SyncCompanyOpeningHourRequest $request)
    {
        $openingHours = $this->companyOpeningHourRepository->sync($company, $request->validated()['opening_hours']);

        return response()->json($openingHours);
    }
}

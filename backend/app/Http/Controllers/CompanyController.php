<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;

use App\Repositories\CompanyRepository;

class CompanyController extends Controller
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Retrieve User Company.
     *
     * @return JsonResponse
     */

    public function userCompany(): JsonResponse
    {
        $user = Auth::user();
        $company = $user->company;

        return response()->json($company);
    }
}

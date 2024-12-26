<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
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
     * Retrieve Company.
     *
     * @param string $slug
     * @return JsonResponse
     */

    public function retrieve(string $slug): JsonResponse
    {
        $company = $this->companyRepository->find($slug);

        if (is_null($company)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        return response()->json($company);
    }
}

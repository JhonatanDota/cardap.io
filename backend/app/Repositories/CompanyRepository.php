<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    /**
     * Retrieve Company by slug field.
     *
     * @param  string $slug
     * @return Company|null
     */

    public function find(string $slug): ?Company
    {
        return Company::find($slug);
    }
}

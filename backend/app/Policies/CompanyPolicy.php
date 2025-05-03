<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;

use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create the model.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return is_null($user->company);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Company  $company
     * @return bool
     */
    public function update(User $user, Company $company): bool
    {
        return $user->id == $company->owner_id;
    }

    /**
     * Determine whether the user can sync the company payment method.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Company  $company
     * @return bool
     */
    public function syncPaymentMethod(User $user, Company $company): bool
    {
        return $user->id == $company->owner_id;
    }
}

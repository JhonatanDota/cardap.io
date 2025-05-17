<?php

namespace App\Rules\CompanyOpeningHour;

use Illuminate\Contracts\Validation\Rule;

use App\Functions\Helpers;

class DuplicatedWeekDayValidation implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!is_array($value)) {
            return true;
        }

        $weekDays = array_column($value, 'week_day');

        return !Helpers::arrayHasDuplicatedValues($weekDays);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute has duplicated week day.';
    }
}

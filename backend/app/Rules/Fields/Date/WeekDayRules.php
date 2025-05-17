<?php

namespace App\Rules\Fields\Date;

use Illuminate\Contracts\Validation\Rule;

use App\Enums\Date\WeekDaysEnum;

class WeekDayRules implements Rule
{
    public function passes($attribute, $value)
    {
        return in_array($value, WeekDaysEnum::values());
    }

    public function message()
    {
        return 'The :attribute field is invalid.';
    }
}

<?php

namespace App\Http\Requests\CompanyOpeningHour;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Fields\Date\WeekDayRules;
use App\Rules\CompanyOpeningHour\DuplicatedWeekDayValidation;

class SyncCompanyOpeningHourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('syncOpeningHour', $this->route('company'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'opening_hours' => ['required', 'array', new DuplicatedWeekDayValidation],
            'opening_hours.*.week_day' => ['required', 'string', new WeekDayRules],
            'opening_hours.*.open_hour' => ['required', 'date_format:H:i', 'string'],
            'opening_hours.*.close_hour' => ['required', 'date_format:H:i', 'string'],
        ];
    }
}

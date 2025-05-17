<?php

namespace App\Http\Requests\CompanyOpeningHour;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Fields\Date\WeekDayRules;

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
            'opening_hours' => ['required', 'array',],
            'opening_hours.*.week_day' => ['required', 'string', new WeekDayRules],
            'opening_hours.*.opening_hour' => ['required', 'date_format:H:i', 'string'],
            'opening_hours.*.closing_hour' => ['required', 'date_format:H:i', 'string'],
        ];
    }
}

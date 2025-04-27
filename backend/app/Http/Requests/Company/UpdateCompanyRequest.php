<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

use App\Models\Company;

use App\Enums\Address\StatesEnum;

use App\Rules\Fields\Commom\CnpjRules;
use App\Rules\Fields\Commom\PhoneRules;
use App\Rules\Fields\Commom\EmailRules;
use App\Rules\Fields\Company\NameRules;
use App\Rules\Fields\Address\StreetRules;
use App\Rules\Validations\PatternsValidation;
use App\Rules\Fields\Address\ComplementRules;
use App\Rules\Fields\Address\NeighborhoodRules;
use App\Rules\Fields\Address\NumberRules;
use App\Rules\Fields\Address\CityRules;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('company'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company = $this->route('company');

        return [
            'name' => ['sometimes', 'string', 'min:' . NameRules::MIN_LENGTH, 'max:' . NameRules::MAX_LENGTH],
            'cnpj' => ['sometimes', 'string', 'regex:' . PatternsValidation::ONLY_DIGITS, 'size:' . CnpjRules::LENGTH, Rule::unique(Company::class, 'cnpj')->ignore($company->id)],
            'email' => ['sometimes', 'string', 'email', 'max:' . EmailRules::MAX_LENGTH, 'regex:' . PatternsValidation::EMAIL_WITH_TLD, Rule::unique(Company::class, 'email')->ignore($company->id)],
            'phone' => ['sometimes', 'string', 'regex:' . PatternsValidation::ONLY_DIGITS, 'size:' . PhoneRules::LENGTH],
            'street' => ['sometimes', 'string', 'min:' . StreetRules::MIN_LENGTH, 'max:' . StreetRules::MAX_LENGTH],
            'number' => ['sometimes', 'string', 'max:' . NumberRules::MAX_LENGTH],
            'complement' => ['nullable', 'string', 'max:' . ComplementRules::MAX_LENGTH],
            'neighborhood' => ['sometimes', 'string', 'min:' . NeighborhoodRules::MIN_LENGTH, 'max:' . NeighborhoodRules::MAX_LENGTH],
            'city' => ['sometimes', 'string', 'min:' . CityRules::MIN_LENGTH, 'max:' . CityRules::MAX_LENGTH],
            'state' => ['sometimes', 'string', Rule::in(StatesEnum::values())],
        ];
    }
}

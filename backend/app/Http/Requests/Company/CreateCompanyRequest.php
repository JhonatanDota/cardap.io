<?php

namespace App\Http\Requests\Company;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

use App\Enums\Address\StatesEnum;

use App\Models\User;
use App\Models\Company;

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

class CreateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Company::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_id' => ['required', Rule::exists(User::class, 'id'), Rule::unique(Company::class, 'owner_id')],
            'name' => ['required', 'string', 'min:' . NameRules::MIN_LENGTH, 'max:' . NameRules::MAX_LENGTH],
            'cnpj' => ['required', 'string', 'regex:' . PatternsValidation::ONLY_DIGITS, 'size:' . CnpjRules::LENGTH, Rule::unique(Company::class, 'cnpj')],
            'email' => ['required', 'string', 'email', 'max:' . EmailRules::MAX_LENGTH, 'regex:' . PatternsValidation::EMAIL_WITH_TLD, Rule::unique(Company::class, 'email')],
            'phone' => ['required', 'string', 'regex:' . PatternsValidation::ONLY_DIGITS, 'size:' . PhoneRules::LENGTH],
            'street' => ['required', 'string', 'min:' . StreetRules::MIN_LENGTH, 'max:' . StreetRules::MAX_LENGTH],
            'number' => ['required', 'string', 'max:' . NumberRules::MAX_LENGTH],
            'complement' => ['nullable', 'string', 'max:' . ComplementRules::MAX_LENGTH],
            'neighborhood' => ['required', 'string', 'min:' . NeighborhoodRules::MIN_LENGTH, 'max:' . NeighborhoodRules::MAX_LENGTH],
            'city' => ['required', 'string', 'min:' . CityRules::MIN_LENGTH, 'max:' . CityRules::MAX_LENGTH],
            'state' => ['required', 'string', Rule::in(StatesEnum::values())],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'owner_id' => Auth::user()->id,
        ]);
    }
}

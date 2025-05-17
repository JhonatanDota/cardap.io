<?php

namespace App\Http\Requests\CompanyPaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Validations\ArrayDuplicatedValuesValidation;
use App\Rules\CompanyPaymentMethod\ValidPaymentMethodsValidation;

class SyncCompanyPaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('syncPaymentMethod', $this->company);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'methods' => ['required', 'array', new ArrayDuplicatedValuesValidation, new ValidPaymentMethodsValidation],
            'methods.*' => ['string'],
        ];
    }
}

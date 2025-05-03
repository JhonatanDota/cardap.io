<?php

namespace App\Rules\CompanyPaymentMethod;

use Illuminate\Contracts\Validation\Rule;

use App\Enums\Financial\PaymentMethodsEnum;

class ValidPaymentMethodsValidation implements Rule
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

        return empty(array_diff($value, PaymentMethodsEnum::values()));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute has invalid payment methods.';
    }
}

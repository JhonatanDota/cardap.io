<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

use App\Rules\ValidationPatterns;

use App\Models\User;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:' . User::NAME_MIN_LENGTH, 'max:' . User::NAME_MAX_LENGTH],
            'email' => ['required', 'string', 'email', 'max:' . User::EMAIL_MAX_LENGTH, 'regex:' . ValidationPatterns::EMAIL_WITH_TLD,  Rule::unique(User::class, 'email')],
            'password' => ['required', 'string', 'min:' . User::PASSWORD_MIN_LENGTH, 'max:' . User::PASSWORD_MAX_LENGTH, 'confirmed']
        ];
    }
}

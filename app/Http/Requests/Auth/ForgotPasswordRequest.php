<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['email' => ['required', 'email', 'exists:users,email']];
    }
    protected function failedValidation(Validator $v)
    {
        throw new HttpResponseException(response()->json(['errors' => $v->errors()], 422));
    }
}

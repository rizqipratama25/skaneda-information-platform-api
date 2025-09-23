<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique'   => 'Username sudah dipakai orang lain',
            'email.required'    => 'Email harus diisi',
            'email.email'       => 'Format email tidak valid',
            'email.unique'      => 'Email ini sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min'      => 'Password minimal 8 karakter',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json(['message' => 'Forbidden'], 403)
        );
    }
}

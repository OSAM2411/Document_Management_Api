<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'   => strip_tags(trim($this->name)),
            'phone' => strip_tags(trim($this->phone)),
            'password' => strip_tags(trim($this->password)),

        ]);
    }
    public function rules(): array
    {
        return [
            'name'     => ['sometimes','string', 'max:255'],
            'phone'    => [ 'sometimes', 'string', Rule::unique('users', 'phone')->ignore($this->route('user'))],
            'password' => [ 'sometimes', 'string', 'min:8'],
            'role'     => [ 'sometimes', 'string', Rule::in(['admin', 'user'])]
        ];
    }
}

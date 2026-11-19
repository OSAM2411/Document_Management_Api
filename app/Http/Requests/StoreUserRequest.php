<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
    public function rules(): array
    {
        $this->merge([
            'name'   => strip_tags(trim($this->name)),
            'phone' => strip_tags(trim($this->phone)),
            'role' => strip_tags(trim($this->role)),

        ]);
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', Rule::unique('users', 'phone')],
            'password' => ['required', 'string', 'min:8'],
            'role'=>['required','string',Rule::in(['admin','user'])]
        ];
    }
}

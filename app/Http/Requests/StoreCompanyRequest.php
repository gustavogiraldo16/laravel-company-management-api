<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nit'     => 'required|string|min:6|max:20|unique:companies,nit',
            'name'    => ['required', 'string', 'max:150', 'not_regex:/^\s*$/'],
            'address' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'status'  => 'in:active,inactive|nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nit.required'   => 'The NIT is required.',
            'nit.unique'     => 'The NIT is already registered.',
            'name.required'  => 'The company name is required.',
            'name.string'    => 'The company name must be a string.',
            'name.max'       => 'The company name must not exceed 150 characters.',
            'name.not_regex' => 'The company name cannot be empty or contain only whitespace.',
            'status.in'      => 'The status must be "active" or "inactive".',
        ];
    }
}

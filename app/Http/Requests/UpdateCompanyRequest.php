<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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

        // Get route parameters (e.g., /api/v1/companies/{nit})
        $companyNit = $this->route('nit');
        if (!$companyNit && $this->has('nit')) {
            $companyNit = $this->input('nit');
        }

        return [
            'nit'     => [
                'sometimes',
                'string',
                'max:20',
                // Rule::unique('companies', 'nit')->ignore($companyNit, 'nit'),
            ],
            'name'    => ['sometimes', 'string', 'max:150', 'not_regex:/^\s*$/'],
            'address' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'status'  => 'in:active,inactive',
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
            'nit.unique'   => 'The NIT is already registered by another company.',
            'name.max'        => 'The name must not exceed 150 characters.',
            'name.not_regex'  => 'The name cannot be empty or contain only whitespace.',
            'status.in'    => 'The status must be "active" or "inactive".',
        ];
    }
}

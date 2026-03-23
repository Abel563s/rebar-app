<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRebarRequirementRequest extends FormRequest
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
            'site_id' => 'required|exists:project_sites,id',
            'structural_element' => 'required|string|max:255',
            'bar_diameter' => 'required|integer|min:1',
            'steel_grade' => 'required|string|in:300,400,500,600',
            'required_length' => 'required|numeric|min:0.001',
            'quantity' => 'required|integer|min:1',
            'drawing_reference' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ];
    }
}


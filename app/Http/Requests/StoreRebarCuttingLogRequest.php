<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRebarCuttingLogRequest extends FormRequest
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
            'rebar_requirement_id' => 'required|exists:rebar_requirements,id',
            'quantity_cut' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $requirement = \App\Models\RebarRequirement::find($this->rebar_requirement_id);
                    if ($requirement && $value > $requirement->quantity) {
                        $fail("The quantity being cut ($value) cannot exceed the available quantity ({$requirement->quantity}).");
                    }
                },
            ],
            'date' => 'required|date',
            'bar_diameter' => 'required|integer|min:1',
            'steel_grade' => 'nullable|string|in:300,400,500,600',
            'original_length' => 'required|numeric|min:0.001',
            'cut_length' => 'required|numeric|min:0.001|lte:original_length',
            'used_for' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ];
    }
}


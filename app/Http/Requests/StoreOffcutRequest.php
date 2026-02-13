<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffcutRequest extends FormRequest
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
            'bar_diameter' => 'required|integer|min:1',
            'length' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'storage_location' => 'nullable|string|max:255',
            'status' => 'required|in:Available,Used,Scrap',
            'remarks' => 'nullable|string',
        ];
    }
}


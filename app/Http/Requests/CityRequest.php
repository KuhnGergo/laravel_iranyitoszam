<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
        if ($this->method() == 'PATCH') {
            return [
                'postal_code' => 'nullable|int',
                'name' => 'nullable|string',
                'county_id' => 'nullable|exists:counties,id',
            ];
        }
        return [
            'postal_code' => 'required|int',
            'name' => 'required|string',
            'county_id' => 'required|exists:counties,id',
        ];
    }

    public function messages() {
        return [
            'postal_code.required' => 'Az irányítószám megadása kötelező.',
            'postal_code.integer' => 'Az irányítószám csak szám lehet.',
            'name.required' => 'A név megadása kötelező.',
            'county_id.exists' => 'A megadott megye nem létezik.',
        ];
    }
}

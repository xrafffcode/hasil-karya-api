<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:projects,code',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'person_in_charge' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
            'province' => 'nullable|string|max:255',
            'regency' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'subdistrict' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'drivers' => 'nullable|array',
            'drivers.*' => 'required|exists:drivers,id',
            'trucks' => 'nullable|array',
            'trucks.*' => 'required|exists:trucks,id',
            'stations' => 'nullable|array',
            'stations.*' => 'required|exists:stations,id',
            'checkers' => 'nullable|array',
            'checkers.*' => 'required|exists:checkers,id',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->has('province')) {
            $this->merge(['province' => null]);
        }
        if (! $this->has('regency')) {
            $this->merge(['regency' => null]);
        }
        if (! $this->has('district')) {
            $this->merge(['district' => null]);
        }
        if (! $this->has('subdistrict')) {
            $this->merge(['subdistrict' => null]);
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:clients,code,'.$this->route('id').',id',
            'name' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'regency' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'subdistrict' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ];
    }

    protected function prepareForValidation()
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

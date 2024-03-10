<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:stations,code,'.$this->route('id').',id',
            'province' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'subdistrict' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'material_id' => 'nullable|exists:materials,id',
            'is_active' => 'required|boolean',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->has('material_id')) {
            $this->merge(['material_id' => null]);
        }
    }
}

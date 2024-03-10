<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTruckRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:trucks,code',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'capacity' => 'required|numeric',
            'production_year' => 'required|date_format:Y',
            'vendor_id' => 'required|exists:vendors,id',
            'is_active' => 'required|boolean',
        ];
    }
}

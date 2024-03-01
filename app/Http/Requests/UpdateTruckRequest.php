<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTruckRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:trucks,code,'.$this->route('truck'),
            'name' => 'required|string|max:255',
            'capacity' => 'required|numeric',
            'is_active' => 'required|boolean',
        ];
    }
}

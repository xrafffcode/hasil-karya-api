<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTechnicalAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:technical_admins,code,'.$this->route('id').',id',
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ];
    }
}

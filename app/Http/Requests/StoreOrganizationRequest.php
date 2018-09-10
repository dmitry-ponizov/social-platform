<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:255",
            'user_name' => "required|string|max:32",
            'surname' => "required|string|max:32",
            "city" => "required|string|max:32",
            "street" => "required|string|max:32",
            "house" => "required|string|max:32",
            "office" => "required|string|max:32",
            "email" => "required|string|max:32",
            'phone' => [
                'required',
                'unique:users',
                'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
            ],
            'organization_phone' => [
                'required',
                'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
            ],
            'password' => 'required|string|min:6',
        ];
    }
}

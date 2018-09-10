<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubcategoryRequest extends FormRequest
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
		    'name' => 'required|max:255',
		    'parent_id' => 'required|numeric',
		    'lang.ru' => 'required',
		    'lang.ua' => 'required',
		    'lang.en' => 'required',
	    ];
    }
}

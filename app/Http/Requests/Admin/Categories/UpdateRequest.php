<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name_en' => 'required_without:name_ar',
            'name_ar' => 'required_without:name_en',
            'description_en' => 'required_without:description_ar',
            'description_ar' => 'required_without:description_en',
            'image' => ['sometimes', 'image']
        ];
    }
}

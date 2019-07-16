<?php

namespace App\Http\Requests\Admin\Warehouses;

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
            'name' => 'required_without:name_ar',
            'name_ar' => 'required_without:name',
            'location' => 'required_without:location_ar',
            'location_ar' => 'required_without:location',
            'shipping_price' => 'required|integer|min:1',
            'related_locations' => 'required|string',
        ];
    }
}

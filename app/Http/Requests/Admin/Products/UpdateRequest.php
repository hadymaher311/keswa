<?php

namespace App\Http\Requests\Admin\Products;

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
            'name_en'               => 'required_without:name_ar',
            'name_ar'               => 'required_without:name_en',
            'description_en'        => 'required_without:description_ar',
            'description_ar'        => 'required_without:description_en',
            'short_description_en'  => 'required_without:short_description_ar',
            'short_description_ar'  => 'required_without:short_description_en',
            'sku'                   => 'required_without:upc|string|min:3',
            'upc'                   => 'required_without:sku|string|min:3',
            'expiry_alarm_before'   => 'required|integer|min:1',
            'categories.*'          => 'required|exists:sub_sub_categories,id',
            'sale_by'               => 'required|in:unit,gram',
            'low_quantity'          => 'required|integer|min:1',
            'quantity_per_packet'   => 'required|integer|min:1',
            'min_sale_quantity'     => 'required|integer|min:1',
            'cost'                  => 'required|integer|min:1',
            'price'                 => 'required|integer|min:1|gt:cost',
            'discount'              => 'nullable|in:value,percentage',
            'discount_value'        => 'nullable|required_if:discount,value,percentage|integer|min:1|lt:price',
            'discount_amount'       => 'nullable|required_if:discount,value,percentage|integer|min:1',
            'width'                 => 'required|integer|min:1',
            'length'                => 'required|integer|min:1',
            'depth'                 => 'required|integer|min:1',
            'weight'                => 'required|integer|min:1',
            'brand'                 => 'required|exists:brands,id',
            'feature_type.*'        => 'nullable',
            'feature_value.*'       => 'nullable',
            'related_product.*'     => 'sometimes|exists:products,id',
            'accessories.*'         => 'sometimes|exists:products,id',
            'tags'                  => 'nullable|string',
        ];
    }
}

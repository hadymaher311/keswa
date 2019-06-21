<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'sku'                   => 'required|string|min:3',
            'expiry_date'           => 'required|date|after:today',
            'categories.*'          => 'required|exists:sub_sub_categories,id',
            'images'                => 'required|array',
            'images.*'              => 'base64image',
            'quantity'              => 'required|integer|min:1|gt:low_quantity',
            'low_quantity'          => 'required|integer|min:1|lt:quantity',
            'quantity_per_packet'   => 'required|integer|min:1',
            'min_sale_quantity'     => 'required|integer|min:1',
            'cost'                  => 'required|integer|min:1',
            'price'                 => 'required|integer|min:1|gt:cost',
            'discount'              => 'nullable|in:value,percentage',
            'discount_value'        => 'nullable|required_if:discount,value,percentage|integer|min:1|lt:price',
            'discount_amount'       => 'nullable|required_if:discount,value,percentage|integer|min:1|lte:quantity',
            'width'                 => 'required|integer|min:1',
            'length'                => 'required|integer|min:1',
            'depth'                 => 'required|integer|min:1',
            'weight'                => 'required|integer|min:1',
            'warehouse'             => 'required|exists:warehouses,id',
            'brand'                 => 'required|exists:brands,id',
            'feature_type.*'        => 'nullable',
            'feature_value.*'       => 'nullable',
            'related_product.*'     => 'sometimes|exists:products,id',
            'accessories.*'         => 'sometimes|exists:products,id',
            'tags'                  => 'nullable|string',
        ];
    }
}

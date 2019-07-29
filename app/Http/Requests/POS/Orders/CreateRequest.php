<?php

namespace App\Http\Requests\POS\Orders;

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
            'comment' => 'nullable|string',
            'products' => 'required|array',
            'products.*' => 'required|exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|min:1',
        ];
    }
}

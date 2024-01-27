<?php

namespace Modules\Vendor\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddShippingPriceRequest extends FormRequest
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
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                    'area_id'        => 'required|exists:areas,id',
                    'shipping_price' => 'required|numeric'
                ];

            //handle updates
            // case 'put':
            // case 'PUT':
            //     return [
            //         'area_id'        => 'required|exists:areas,id',
            //         'shipping_price' => 'required|numeric',
            //     ];
        }
    }

    public function messages()
    {
        $validationMessages = [
            'area_id.required'        => __('area_id is required'),
            'area_id.exists'          => __('Invalid area ID. Please provide a valid area ID'),

            'shipping_price.required' => __('shipping_price is required'),
            'shipping_price.numeric'  => __('shipping_price should be numeric'),
        ];

        return $validationMessages;
    }
}

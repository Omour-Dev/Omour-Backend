<?php

namespace Modules\Order\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
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
                    'doctor_id'    => 'required',
                    'service_id'   => 'required',
                    'date'         => 'required',
                    'time_from'    => 'required',
                    'time_to'      => 'required',
                ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'doctor_id.required'   => __('order::api.orders.validations.doctor_id.required'),
            'service_id.required'  => __('order::api.orders.validations.service_id.required'),
            'time_from.required'   => __('order::api.orders.validations.time_from.required'),
            'time_to.required'     => __('order::api.orders.validations.time_to.required'),
            'date.required'        => __('order::api.orders.validations.date.required'),
        ];

        return $v;
    }
}

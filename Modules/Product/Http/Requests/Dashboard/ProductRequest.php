<?php

namespace Modules\Product\Http\Requests\Dashboard;

use Modules\Product\Rules\SkuUnique;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
                // handle creates
            case 'post':
            case 'POST':

                return [
                    'title.*'             => 'required',
                    'vendor_id'           => 'required',
                    'image'               => 'required',
                    'category_id'         => 'required',
                    'price'               => 'required|numeric',
                    'qty'                 => 'required|numeric',
                    'sku'                 => ['required', new SkuUnique($this->vendor_id)],
                    'offer_price'         => 'sometimes|required|numeric',
                    'start_at'            => 'sometimes|required|date',
                    'end_at'              => 'sometimes|required|date',
                    'arrival_start_at'    => 'sometimes|required|date',
                    'arrival_end_at'      => 'sometimes|required|date',
                    'variation_price.*'   => 'sometimes|required',
                    'variation_qty.*'     => 'sometimes|required',
                    'variation_status.*'  => 'sometimes|required',
                    'variation_sku.*'     => 'sometimes|required',
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'             => 'required',
                    'vendor_id'           => 'required',
                    'category_id'         => 'required',
                    'price'               => 'required|numeric',
                    'qty'                 => 'required|numeric',
                    'sku'                 => ['required', new SkuUnique($this->vendor_id)],
                    'offer_price'         => 'sometimes|required|numeric',
                    'start_at'            => 'sometimes|required|date',
                    'end_at'              => 'sometimes|required|date',
                    'arrival_start_at'    => 'sometimes|required|date',
                    'arrival_end_at'      => 'sometimes|required|date',
                    'variation_price.*'   => 'sometimes|required',
                    'variation_qty.*'     => 'sometimes|required',
                    'variation_status.*'  => 'sometimes|required',
                    'variation_sku.*'     => 'sometimes|required',
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
            'variation_price.*.required'    => __('product::dashboard.products.validation.variation_price.required'),
            'variation_qty.*.required'      => __('product::dashboard.products.validation.variation_qty.required'),
            'variation_status.*.required'   => __('product::dashboard.products.validation.variation_status.required'),
            'variation_sku.*.required'      => __('product::dashboard.products.validation.variation_sku.required'),
            'category_id.required'          => __('product::dashboard.products.validation.category_id.required'),
            'vendor_id.required'            => __('product::dashboard.products.validation.vendor_id.required'),
            'image.required'                => __('product::dashboard.products.validation.image.required'),
            'price.required'                => __('product::dashboard.products.validation.price.required'),
            'price.numeric'                 => __('product::dashboard.products.validation.price.numeric'),
            'sku.required'                  => __('product::dashboard.products.validation.sku.required'),
            'qty.required'                  => __('product::dashboard.products.validation.qty.required'),
            'qty.numeric'                   => __('product::dashboard.products.validation.qty.numeric'),
            'offer_price.required'          => __('product::dashboard.products.validation.offer_price.required'),
            'offer_price.numeric'           => __('product::dashboard.products.validation.offer_price.numeric'),
            'start_at.required'             => __('product::dashboard.products.validation.start_at.required'),
            'start_at.date'                 => __('product::dashboard.products.validation.start_at.date'),
            'end_at.required'               => __('product::dashboard.products.validation.end_at.required'),
            'end_at.date'                   => __('product::dashboard.products.validation.end_at.date'),
            'arrival_start_at.required'     => __('product::dashboard.products.validation.arrival_start_at.required'),
            'arrival_start_at.date'         => __('product::dashboard.products.validation.arrival_start_at.date'),
            'arrival_end_at.required'       => __('product::dashboard.products.validation.arrival_end_at.required'),
            'arrival_end_at.date'           => __('product::dashboard.products.validation.arrival_end_at.date'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

            $v["title." . $key . ".required"]  = __('product::dashboard.products.validation.title.required') . ' - ' . $value['native'] . '';

            // $v["title.".$key.".unique"]    = __('product::dashboard.products.validation.title.unique').' - '.$value['native'].'';

        }


        return $v;
    }
}

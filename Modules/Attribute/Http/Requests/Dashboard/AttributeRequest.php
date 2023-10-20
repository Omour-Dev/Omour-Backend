<?php

namespace Modules\Attribute\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
                  'title.*'         => 'required|unique:attribute_translations,title',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'      => 'required|unique:attribute_translations,title,'.$this->id.',attribute_id',
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

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  = __('attribute::dashboard.attributes.validation.title.required').' - '.$value['native'].'';

          $v["title.".$key.".unique"]    = __('attribute::dashboard.attributes.validation.title.unique').' - '.$value['native'].'';

        }

        return $v;

    }
}

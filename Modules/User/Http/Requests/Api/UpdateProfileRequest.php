<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'name'            => 'nullable',
                    'mobile'          => 'nullable|numeric|unique:users,mobile,'.auth()->id().'',
                    'email'           => 'nullable|unique:users,email,'.auth()->id().'',
                ];
        }
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'name.required'           => __('user::api.users.validation.name.required'),
            'email.required'          => __('user::api.users.validation.email.required'),
            'email.unique'            => __('user::api.users.validation.email.unique'),
            'mobile.required'         => __('user::api.users.validation.mobile.required'),
            'mobile.unique'           => __('user::api.users.validation.mobile.unique'),
            'mobile.numeric'          => __('user::api.users.validation.mobile.numeric'),
        ];

        return $v;
    }
}

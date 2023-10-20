<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'name'            => 'required',
                    'mobile' => ['required', 'numeric', 'digits:11', 'unique:users,mobile', 'regex:/^0\d{10}$/'],
                    'email'           => 'required|unique:users,email',
                    'password'        => 'required|min:6|same:confirm_password',
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'name'            => 'required',
                    'mobile' => ['required', 'numeric', Rule::unique('users')->ignore($this->id), 'digits:11', 'regex:/^0[0-9]{10}$/'],
                    'email'           => 'required|unique:users,email,' . $this->id . '',
                    'password'        => 'nullable|min:6|same:confirm_password',
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
            'name.required'           => __('user::dashboard.users.validation.name.required'),
            'email.required'          => __('user::dashboard.users.validation.email.required'),
            'email.unique'            => __('user::dashboard.users.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.users.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.users.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.users.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.users.validation.mobile.digits_between'),
            'password.required'       => __('user::dashboard.users.validation.password.required'),
            'password.min'            => __('user::dashboard.users.validation.password.min'),
            'password.same'           => __('user::dashboard.users.validation.password.same'),
        ];

        return $v;
    }
}

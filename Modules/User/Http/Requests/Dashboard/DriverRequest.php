<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
                    'roles'           => 'required',
                    'name'            => 'required',
                    'mobile' => ['required', 'numeric', 'digits:11', 'unique:users,mobile', 'regex:/^0\d{10}$/'],
                    'email'           => 'required|unique:users,email',
                    'password'        => 'required|min:6|same:confirm_password',
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'roles'           => 'required',
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
            'roles.required'          => __('user::dashboard.drivers.validation.roles.required'),
            'name.required'           => __('user::dashboard.drivers.validation.name.required'),
            'email.required'          => __('user::dashboard.drivers.validation.email.required'),
            'email.unique'            => __('user::dashboard.drivers.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.drivers.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.drivers.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.drivers.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.drivers.validation.mobile.digits_between'),
            'password.required'       => __('user::dashboard.drivers.validation.password.required'),
            'password.min'            => __('user::dashboard.drivers.validation.password.min'),
            'password.same'           => __('user::dashboard.drivers.validation.password.same'),
        ];

        return $v;
    }
}

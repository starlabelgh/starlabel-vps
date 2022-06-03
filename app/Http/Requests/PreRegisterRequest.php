<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreRegisterRequest extends FormRequest
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
        if ($this->pre_register) {
            $email    = ['required', 'email', 'string', Rule::unique("visitors", "email")->ignore($this->pre_register->visitor_id)];
            $phone    = ['required', 'string', Rule::unique("visitors", "phone")->ignore($this->pre_register->visitor_id)];
        } else {
            $email    = ['required', 'email', 'string', 'unique:visitors,email'];
            $phone    = ['required', 'string', 'unique:visitors,phone'];
        }
        return [
            'first_name'                => 'required|string|max:100',
            'last_name'                 => 'required|string|max:100',
            'email'                     => $email,
            'phone'                     => $phone,
            'employee_id'               => 'required|numeric',
            'gender'                    => 'required|numeric',
            'expected_date'             => 'required',
            'expected_time'             => 'required',
            'comment'                   => 'nullable|max:191',
            'address'                   => 'nullable|max:191',
        ];
    }
}

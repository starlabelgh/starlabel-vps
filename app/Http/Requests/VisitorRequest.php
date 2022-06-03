<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisitorRequest extends FormRequest
{

    private $visitor_id;
    public  function __construct($id =null)
    {
        parent::__construct();
        $this->visitor_id = $id ? $id : 0;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->visitor) {
            $email    = ['required', 'email', 'string', Rule::unique("visitors", "email")->ignore($this->visitor->visitor_id)];
            $phone= ['required', 'string', Rule::unique("visitors", "phone")->ignore($this->visitor->visitor_id)];

        } elseif($this->visitor_id){
            $email    = ['required', 'email', 'string'];
            $phone    = ['required', 'string'];
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
            'company_name'              => 'nullable|max:100',
            'national_identification_no'=> 'nullable|max:100',
            'purpose'                   => 'required|max:191',
            'address'                   => 'nullable|max:191',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg|max:5098',
        ];
    }
}

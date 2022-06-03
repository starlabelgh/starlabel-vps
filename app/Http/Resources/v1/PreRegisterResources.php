<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PreRegisterResources extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"            => $this->id,
            "first_name"    => $this->first_name,
            "last_name"     => $this->last_name,
            "name"          => $this->name,
            "email"         => $this->email,
            "phone"         => $this->phone,
            "gender"        => trans('genders.' . $this->gender),
            "address"       => $this->address,
            "expected_date" => date('Y-m-d', strtotime($this->expected_date)),
            "expected_time" => date('h:i A', strtotime($this->expected_time)),
            "employee_name" => !blank($this->preregister) ? $this->preregister->employee->name : '',
            "employeeID" => !blank($this->preregister) ? $this->preregister->employee->id : '',
            "image"         => !blank($this->image) ? $this->image : '',
            "comment"       => $this->comment,
            "status"        => trans('statuses.' . $this->status),

        ];
    }
}

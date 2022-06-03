<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SingleVisitorResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"                  => $this->id,
            "first_name"          => $this->first_name,
            "last_name"           => $this->last_name,
            "name"                => $this->name,
            "email"               => $this->email,
            "phone"               => $this->phone,
            "national_identification_no"   => $this->national_identification_no,
            "gender"        => trans('genders.' . $this->gender),
            "address"       => $this->address,
            "image"         => !blank($this->image) ? $this->image : '',
            "status"        => trans('statuses.' . $this->status),
        ];
    }
}

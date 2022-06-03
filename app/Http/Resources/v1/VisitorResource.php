<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;


class VisitorResource extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection;
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return AnonymousResourceCollection
     */
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return ReportResource::collection($this->collection);
    }
}

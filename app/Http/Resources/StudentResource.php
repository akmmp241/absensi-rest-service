<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "nis" => $this->nis,
            "name" => $this->name,
            "class" => $this->class,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "supervisor" => new SupervisorResource($this->supervisor),
            "dudi" => new DudiResource($this->dudi),
        ];
    }
}

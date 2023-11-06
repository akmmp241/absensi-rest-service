<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupervisorResource extends JsonResource
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
            "nip" => $this->nip,
            "name" => $this->name,
            "createdAt" => $this->created_at->format("Y-m-d H:i:s"),
            "updatedAt" => $this->updated_at->format("Y-m-d H:i:s"),
        ];
    }
}

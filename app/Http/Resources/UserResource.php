<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "role_id" => $this->role_id,
            "name" => $this->name,
            "username" => $this->username,
            "createdAt" => $this->created_at->format("Y-m-d H:i:s"),
            "updatedAt" => $this->updated_at->format("Y-m-d H:i:s"),
        ];
    }
}

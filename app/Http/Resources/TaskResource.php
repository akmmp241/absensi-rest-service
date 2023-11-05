<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            "report_id" => $this->report_id,
            "type" => $this->type,
            "image" => env('APP_URL') . '/' . $this->image,
            "detail" => $this->detail,
            "status" => $this->status,
            "confirmed_by" => new SupervisorResource($this->confirmedBy),
            "confirmed_at" => $this->confirmed_at ? $this->confirmed_at->format('Y-m-d H:i:s') : null,
            "createdAt" => $this->created_at->format('Y-m-d H:i:s'),
            "updatedAt" => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}

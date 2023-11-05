<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            "student" => new StudentResource($this->student),
            "dudi" => new DudiResource($this->dudi),
            "date" => $this->date->format('Y-m-d'),
            "createdAt" => $this->created_at->format('Y-m-d H:i:s'),
            "updatedAt" => $this->updated_at->format('Y-m-d H:i:s'),
            "tasks" => new TasksCollection($this->tasks),
        ];
    }
}

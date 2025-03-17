<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SituationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subject_id' => new SubjectResource($this->subject),
            'student_id' => new StudentResource($this->student),
            'day' => $this->day,
            'recipe' => $this->recipe,
            'eat_status' => $this->eat_status,
            'note' => $this->note,
            'review' => $this->review,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->createdBy,
            'updated_by' => $this->updatedBy,
        ];
    }
}

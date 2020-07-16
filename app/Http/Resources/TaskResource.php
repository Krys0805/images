<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'groupId' => $this->group_id,
            'taskClassName' => $this->task_class_name,
            'taskParams' => $this->task_params,
            'createdAt' => (string) $this->created_at,
            'updatedAt' => (string) $this->updated_at,
        ];
    }
}

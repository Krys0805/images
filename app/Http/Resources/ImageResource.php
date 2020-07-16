<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'name' => $this->name,
            'ext' => $this->ext,
            'mime' => $this->mime,
            'path' => $this->path,
            'groupId' => $this->group_id,
            'groupTaskId' => $this->group_task_id,
            'createdAt' => (string) $this->created_at,
            'updatedAt' => (string) $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'list' => $this->collection->map(function (Image $image) {
                return [
                    'id' => $image->id,
                    'name' => $image->name,
                    'ext' => $image->ext,
                    'mime' => $image->mime,
                    'path' => $image->path,
                    'groupId' => $image->group_id,
                    'groupTaskId' => $image->group_task_id,
                    'createdAt' => (string) $image->created_at,
                    'updatedAt' => (string) $image->updated_at,
                ];
            })
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Group\Task;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
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
            'list' => $this->collection->map(function (Task $task) {
                return [
                    'id' => $task->id,
                    'groupId' => $task->group_id,
                    'taskClassName' => $task->task_class_name,
                    'taskParams' => $task->task_params,
                    'createdAt' => (string) $task->created_at,
                    'updatedAt' => (string) $task->updated_at,
                ];
            })
        ];
    }
}

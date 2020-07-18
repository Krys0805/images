<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Group\Task;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/tasks",
     *     @OA\Response(response="200", description="Ok")
     * )
     *
     * @return TaskCollection
     */
    public function index()
    {
        return new TaskCollection(Task::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/tasks",
     *     @OA\Response(response="201", description="Ok")
     * )
     *
     * @param  TaskRequest $request
     * @return TaskResource
     */
    public function store(TaskRequest $request)
    {
        $task = new Task($request->all());
        $task->save();
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/tasks/{task}",
     *     @OA\Response(response="200", description="Ok")
     * )
     *
     * @param Task $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *     path="/api/tasks",
     *     @OA\Response(response="200", description="Ok")
     * )
     *
     * @param  TaskRequest $request
     * @param Task $task
     * @return TaskResource
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->all());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/tasks",
     *     @OA\Response(response="204", description="Ok")
     * )
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task->delete()) {
            return response(null, 204);
        }
    }
}

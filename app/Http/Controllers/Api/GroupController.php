<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Group;

/**
 * @OA\Info(title="My First API", version="0.1")
 */

class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/groups",
     *     @OA\Response(response="200", description="Ok")
     * )
     *
     * @return GroupCollection
     */
    public function index()
    {
        return new GroupCollection(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/groups",
     *     @OA\Response(response="201", description="Ok")
     * )
     *
     * @param  GroupRequest  $request
     * @return GroupResource
     */
    public function store(GroupRequest $request)
    {
        $group = new Group($request->all());
        $group->save();
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/groups/{group}",
     *     @OA\Response(response="200", description="Ok")
     * )
     *
     * @param Group $group
     * @return GroupResource
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *     path="/api/groups",
     *     @OA\Response(response="200", description="Ok")
     * )
     *
     * @param  GroupRequest  $request
     * @param Group $group
     * @return GroupResource
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->all());
        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/groups",
     *     @OA\Response(response="204", description="Ok")
     * )
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if ($group->delete()) {
            return response(null, 204);
        }
    }
}

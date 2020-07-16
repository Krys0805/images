<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageCollection;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return ImageCollection
     */
    public function index()
    {
        return new ImageCollection(Image::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest  $request
     * @return ImageResource
     */
    public function store(ImageRequest $request)
    {
        $image = new Image($request->all());
        $image->save();
        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param Image $image
     * @return ImageResource
     */
    public function show(Image $image)
    {
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageRequest  $request
     * @param Image $image
     * @return ImageResource
     */
    public function update(ImageRequest $request, Image $image)
    {
        $image->update($request->all());
        return new ImageResource($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Image $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        if ($image->delete()) {
            return response(null, 204);
        }
    }

    /**
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $result = [];
        $paths = $request->json('paths', []);

        $groups = $request->json('groups', []);
        if (empty($groups)) {
            return response(null, 404);
        }

        foreach ($request->files as $path => $files) {
            $i = 0;
            /** @var UploadedFile $file */
            foreach ($files as $file) {
                $ext = $file->getClientOriginalExtension();
                $img = [
                    'name' => $i++ . '.' . $ext,
                    'path' => 'images/' . (!empty($paths[$path]) ? $paths[$path] : $path),
                    'ext' => $ext,
                    'mime' => $file->getClientMimeType(),
                    'group_id' => 0,
                    'group_task_id' => 0,
                ];
                if (!in_array($ext, ['pdf', 'jpg', 'png', 'docx'])) {
                    return response(null, 404);
                }
                try {
                    Image::create($img);
                    $file->storeAs($img['path'], $img['name'], 'public');
                    $result[] = $img;
                } catch (\Exception $e) {
                    return response($e->getMessage(), 500);
                }
            }
        }
        return response($result, 200);
    }

    protected function addTasks(array $groups)
    {
        // get groups if exists by name

        // get tasks if groups nor empty

        // create job handleImageTasks
        // dispatch image to job HERE - e/g/  // add tasks in queue
        // set queue with Redis

        // !!! need to create groups-tasks threw admin area
    }
}

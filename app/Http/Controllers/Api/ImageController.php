<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageCollection;
use App\Http\Resources\ImageResource;
use App\Jobs\DownloadImage;
use App\Jobs\ProcessImageTasks;
use App\Models\Group;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/images",
     *     @OA\Response(response="200", description="Ok")
     * )
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
     * @OA\Post(
     *     path="/api/images",
     *     @OA\Response(response="201", description="Ok")
     * )
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
     * @OA\Get(
     *     path="/api/images/{image}",
     *     @OA\Response(response="200", description="Ok")
     * )
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
     * @OA\Patch(
     *     path="/api/images",
     *     @OA\Response(response="200", description="Ok")
     * )
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
     * @OA\Delete(
     *     path="/api/images",
     *     @OA\Response(response="204", description="Ok")
     * )
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
     * Upload images
     *
     * @OA\Post(
     *     path="/api/images/upload",
     *     @OA\Response(response="200", description="Ok")
     * )
     *
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $result = [];
        $paths = $request->json('paths', []);

        $groupsIds = $request->json('groups', []);
        $groups = Group::query()->whereIn('id', $groupsIds)->orWhereIn('name', $groupsIds)->get();

        foreach ($request->files as $path => $files) {
            $i = 0;
            /** @var UploadedFile $file */
            foreach ($files as $file) {
                $imageStoragePath = !empty($paths[$path]) ? $paths[$path] : $path;
                if (!$file instanceof UploadedFile) {
                    if (filter_var($file, FILTER_VALIDATE_URL)) {
                        DownloadImage::dispatch(Image\Download::create([
                            'url' => $file,
                            'name' => $i++,
                            'path' => $imageStoragePath,
                            'groups' => json_encode($groupsIds),
                        ]))->onQueue('image_downloads');
                    }
                    continue;
                }
                $ext = $file->getClientOriginalExtension();
                $img = [
                    'name' => $i++ . '.' . $ext,
                    'path' => 'images/' . $imageStoragePath,
                    'ext' => $ext,
                    'mime' => $file->getClientMimeType(),
                    'group_id' => 0,
                    'group_task_id' => 0,
                ];
                if (!in_array($ext, ['pdf', 'jpg', 'png', 'docx'])) {
                    return response(null, 404);
                }
                DB::beginTransaction();
                try {
                    $file->storeAs($img['path'], $img['name'], 'public');
                    $image = Image::create($img);
                    $image->groups()->attach($groups);
                    ProcessImageTasks::dispatch($image)->onQueue('image_tasks');
                    $result[] = $img;
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response($e->getMessage(), 500);
                }
            }
        }
        return response($result, 200);
    }
}

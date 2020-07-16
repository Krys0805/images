<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageTest extends ResourceAbstract
{

    protected function getEndpointName(): string
    {
        return 'images';
    }

    protected function getStoreData(): array
    {
        return [
            'name' => 'test',
            'group_id' => 1,
            'group_task_id' => 1,
            'path' => 'images/file',
            'ext' => 'jpg',
            'mime' => 'image/jpeg',
        ];
    }

    protected function getUpdateData(): array
    {
        return [
            'name' => 'updated name',
            'group_id' => 2,
            'group_task_id' => 2,
        ];
    }

    protected function getReturnEntityStruct(): array
    {
        return ['id', 'name', 'groupId', 'groupTaskId', 'createdAt', 'updatedAt'];
    }

    public function testUpload()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');
        $file2 = UploadedFile::fake()->image('test2.jpg');
        $file3 = UploadedFile::fake()->image('test3.jpg');
        $file4 = UploadedFile::fake()->image('test4.png');

        $response = $this->postJson('/api/' . $this->getEndpointName() . '/upload', [
            'file' => [$file],
            'test_path' => [$file2],
            'file/2' => [$file3, $file4],
            'groups' => ['gg'],
            'paths' => [
                'test_path' => 'file/test_path/2',
            ],
        ], ['Content-Type' => 'multipart/form-data']);

        $response->assertStatus(200);

        // Assert the file was stored...
        Storage::disk('public')->assertExists('images/file/0.jpg');
        Storage::disk('public')->assertExists('images/file/test_path/2/0.jpg');
        Storage::disk('public')->assertExists('images/file/2/0.jpg');
        Storage::disk('public')->assertExists('images/file/2/1.png');

        // Assert a file does not exist...
        Storage::disk('public')->assertMissing('missing.jpg');
    }
}

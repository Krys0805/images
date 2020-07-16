<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends ResourceAbstract
{

    protected function getEndpointName(): string
    {
        return 'tasks';
    }

    protected function getStoreData(): array
    {
        return [
            'group_id' => 1,
            'task_class_name' => 'test',
            'task_params' => 'test',
        ];
    }

    protected function getUpdateData(): array
    {
        return [
            'group_id' => 2,
            'task_class_name' => 'updated test',
            'task_params' => 'updated test',
        ];
    }

    protected function getReturnEntityStruct(): array
    {
        return ['id', 'groupId', 'taskClassName', 'taskParams', 'createdAt', 'updatedAt'];
    }
}

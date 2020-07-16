<?php

namespace App\Models\Group;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'group_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'task_class_name', 'task_params',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}

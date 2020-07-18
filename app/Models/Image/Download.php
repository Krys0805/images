<?php

namespace App\Models\Image;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table = 'image_downloads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'path', 'image_id', 'groups',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}

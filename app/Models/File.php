<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'original_name',
        'mime_type',
        'path',
        'size',
        'disk'
    ];

    protected $casts = [
        'size' => 'integer'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageManipulation extends Model
{
    use HasFactory;

    const UPDATED_AT = null;


    protected $fillable = [
        "type",
        "name",
        "path",
        "output_path",
        "album_id",
        "data",
        "user_id"

    ];
}

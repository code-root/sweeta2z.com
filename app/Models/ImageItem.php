<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'original_name',
        'language',
        'table_name',
        'table_id',
        'image_size',
        'status',
        'token'
    ];
}

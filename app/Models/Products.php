<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'rel_id', 'name', 'token', 'word', 'words_title', 'title',  'price_before', 'price', 'description'];

    public function category() {
        return $this->belongsTo(Category::class);
    }



    public function image() {
        return $this->hasMany(ImageItem::class , 'token' , 'token');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasFactory;
    protected $fillable = ['name', 'title', 'token'];
    protected $primaryKey = 'id';


    public function image() {
        return $this->hasMany(ImageItem::class , 'token' , 'token');
    }

    public function products(){
        return $this->hasMany(Products::class , 'category_id', 'id' );
    }


}

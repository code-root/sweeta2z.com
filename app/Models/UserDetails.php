<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'marital_status',
        'skin_color',
        'specialization',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

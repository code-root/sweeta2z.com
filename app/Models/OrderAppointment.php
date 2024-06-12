<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAppointment extends Model
{
    use HasFactory;

    protected $table = 'order_appointment';
    protected $fillable = ['order_id', 'time', 'date'];



}

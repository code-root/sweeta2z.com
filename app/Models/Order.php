<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'country_id',
        'area_id',
        'name',
        'email',
        'number',
        'special_request',
        'price',
        'address',
        'device',
        'ip_address',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }


    public function OrderAppointment()
    {
        return $this->hasMany(OrderAppointment::class, 'order_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'order_id');
    }
}

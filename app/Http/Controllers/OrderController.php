<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {

    public function index() {
         $orders = Order::orderBy('created_at', 'desc')->with(['cartItems.product' ,'area','country', 'OrderAppointment' , 'OrderAppointment.Appointment' , 'OrderAppointment.Appointment.day'])->get();
        return view('dashboard.orders.index', compact('orders'));
    }

}

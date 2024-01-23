<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Models\Order;

class OrderRepository extends Controller
{
    public function getAll()
    {
        return Order::all();
    }

    public function getDetails($id)
    {
        return Order::find($id);
    }

    public function getSpecializationNameById($id)
    {
        //
    }

}

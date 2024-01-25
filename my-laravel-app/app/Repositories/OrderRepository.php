<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\OrderService;

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

    public function getServicesId($id)
    {
        $orderServices = OrderService::where('order_id', $id)->pluck('service_id');
        return $orderServices;
    }

    public function saveOrder(array $data)
    {
        //сохранение заказ-наряда
        $order = new Order();
        $order->client_id = $data['clientId'];
        $order->specialization_id = $data['specializationId'];
        $order->total_amount = (int)$data['totalAmount'];
        $order->materials = $data['materials'];
        $order->comments = $data['comments'];
        $order->save();

        if (isset($data['servicesId']) && is_array($data['servicesId'])) {
            $order->services()->attach($data['servicesId']);
            return $order;
        } else {
            return null;
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Routing\Controller;
use function Laravel\Prompts\error;

class OrderController extends Controller
{
    //получение всех ордеров
    public function getAllOrders()
    {
        $orders = Order::all();
        if ($orders) {
            return response()->json($orders);
        } else {
            return response()->json(['error' => 'ордеров нет']);
        }
    }

    public function getOrderDetails($orderId){
        $order = Order::find($orderId);
        if (!$order){
            return response()->json(['message' => 'ордер'. $orderId . ' не найден']);
        } else {
            return response()->json($order);
        }
    }

}

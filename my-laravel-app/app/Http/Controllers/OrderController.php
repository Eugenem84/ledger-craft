<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Specialization;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use function Laravel\Prompts\error;
use App\Repositories\SpecializationRepository;
use App\Repositories\ClientRepository;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $specializationRepository;
    protected $clientReposutory;

    public function __construct(OrderRepository $orderRepository,
                                SpecializationRepository $specializationRepository,
                                ClientRepository $clientRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->specializationRepository = $specializationRepository;
        $this->clientReposutory = $clientRepository;
    }

    public function getAll()
    {
        $orders = $this->orderRepository->getAll();
        foreach ($orders as $order) {
            $clientId = $order->client_id;
            $specializationId = $order->specialization_id;

            $clientName = $this->clientReposutory->getName($clientId);
            $specializationName = $this->specializationRepository->getName($specializationId);

            if($specializationName){
                $order->specialization_name = $specializationName;
            } else {
                $order->specialization_name = 'no name';
            }

            if ($clientName){
                $order->client_name = $clientName;
            } else {
                $order->specialization_name = 'no name';
            }

        }
        if ($orders) {
            return response()->json($orders);
        } else {
            return response()->json(['error' => 'ордеров нет']);
        }
    }

    public function getDetails($id){
        $order = $this->orderRepository->getDetails($id);
        if (!$order){
            return response()->json(['message' => 'ордер'. $id . ' не найден']);
        } else {
            return response()->json($order);
        }
    }

}

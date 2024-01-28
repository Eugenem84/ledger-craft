<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use function Laravel\Prompts\error;
use App\Repositories\SpecializationRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ServiceRepository;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $specializationRepository;
    protected $clientReposutory;
    protected $serviceRepository;

    public function __construct(OrderRepository $orderRepository,
                                SpecializationRepository $specializationRepository,
                                ClientRepository $clientRepository,
                                ServiceRepository $serviceRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->specializationRepository = $specializationRepository;
        $this->clientReposutory = $clientRepository;
        $this->serviceRepository = $serviceRepository;
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

    public function getServices($orderId)
    {
        $services = [];
        $servicesId = $this->orderRepository->getServicesId($orderId);
        foreach ($servicesId as $serviceId){
            $service = $this->serviceRepository->getService($serviceId);
            $services[] = $service;
        }
        return $services;

    }

    public function saveOrder(Request $request)
    {
        $data = $request->only(['clientId', 'specializationId', 'totalAmount', 'materials', 'comments']);
        $data['servicesId'] = $request->input('servicesId');
        $order = $this->orderRepository->saveOrder($data);
        if ($order){
            return response()->json(['message' => 'ордер сохранен']);
        } else {
            return response()->json(['error' => 'ошибка записи ордера']);
        }
    }

    public function updateOrder(Request $request)
    {
        $data = $request->only([ 'id','clientId', 'specializationId', 'materials', 'comments', 'totalAmount',]);
        $data['servicesId'] = $request->input('servicesId');
        $order = $this->orderRepository->updateOrder($data);
        if ($order){
            return response()->json(['message' => 'ордер обновлен']);
        } else {
            return response()->json(['error' => 'ошибка обновления ордера']);
        }
    }

    public function deleteOrder($id)
    {
        $order = $this->orderRepository->deleteOrder($id);
        if ($order){
            return response()->json(['message' => 'Ордер успешно удален'], 200);
        } else {
            return response()->json(['error' => 'ордер не найден'], 404);
        }
    }
}

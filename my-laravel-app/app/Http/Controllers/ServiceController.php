<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class ServiceController extends Controller
{
    public function show()
    {
        $categories = Category::all();
        $services = Service::all();
        return view('service.show', compact('categories', 'services'));

    }

    public function editServices() {
        $categories = Category::all();
        $services = Service::all();
        return view('service.edit', compact('categories', 'services'));
    }

    public function showHistoryOrders(){
        return view('service.history');
    }

    public function showStatistics(){
        return view('service.statistic');
    }

    public function addNewService(Request $request){
        $service = new Service;
        $service->service = $request->input('service');
        $service->price = $request->input('price');
        $service->save();
    }

    public function deleteService(Request $request){
        $serviceId = $request->input('serviceId');

        $service = Service::find($serviceId);
        if ($service){
            $service->delete();
            return response()->json(['message' => 'Сурвис успешно удален'], 200);
        } else {
            return response()->json(['message' => 'Сервис не найден'], 404);
        }
    }

    public function editService(Request $request){
        echo 'echo is work';
        try {

            $serviceId = $request->input('id');
            $serviceName = $request->input('service');
            $servicePrice = $request->input('price');
            $service = Service::find($serviceId);
            if ($service) {
                $service->name = $serviceName;
                $service->price = $servicePrice;
                $service->save();

                return response()->json(['message' => 'Сервис успешно изменен'], 200);
            } else {
                return response()->json(['message' => 'Сервис не найден'], 404);
            }

        } catch (Exception $e){
            return response()->json(['message' => 'Ошибка: ' . $e->getMessage()], 500);
        }

    }

}

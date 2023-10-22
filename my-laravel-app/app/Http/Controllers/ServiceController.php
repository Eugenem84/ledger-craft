<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show()
    {
        $services = Service::all();
        return view('service.show', ['services' => $services]);
    }

    public function editServices() {
        $services = Service::all();
        return view('service.edit', ['services' => $services]);
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

    public function editService(){

    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Models\Specialization;
use http\Env\Response;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class ServiceController extends Controller
{
    public function show()
    {
        $specializations = Specialization::all();
        $categories = Category::all();
        $services = Service::all();
        $clients = Client::all();

        return view('service.show', compact('categories', 'services', 'specializations', 'clients'));
    }

    public function showOrderDetails($orderId){
        $order = Order::find($orderId);
        if (!$order){
            return view(404,'order.not_found');
        } else {
            return view('service.order', ['order' => $order]);
        }
    }

    public function getCategoriesBySpecialization($specializationId){
        $categories = Category::where('specialization_id', $specializationId)->get();
        if ($categories) {
            return response()->json($categories);
        } else {
            return response()->json(['message' => 'У данной специализации нет категорий']);
        }
    }

    public function getServicesByCategory($categoryId){
        $services = Service::where('category_id', $categoryId)->get();
        if ($services) {
            return response()->json($services);
        } else {
            return response()->json('нет сервисов в данной категории');
        }
    }

    public function getClientsBySpecialization($specializationId){
        $clients = Client::where('specialization_id', $specializationId)->get();
        if ($clients->isEmpty()){
            return response()->json(['message' => 'У данной специализации нет клиентов']);
        } else {
            return response()->json($clients);
        }
    }

    public function editServices() {
        $categories = Category::all();
        $services = Service::all();
        $specializations = Specialization::all();
        $clients = Client::all();
        return view('service.edit', compact('categories', 'services', 'specializations', 'clients'));
    }

    public function showHistoryOrders(){
        $orders = Order::all();
        return view('service.history', ['orders' => $orders]);
    }

    public function showStatistics(){
        return view('service.statistic');
    }

    public function deleteSpecialization(Request $request){
        $specializationId = $request->input('specializationId');
        $specialization = Specialization::find($specializationId);
        if ($specialization){
            $specialization->categories()->each(function ($category){
                $category->services()->delete();
                $category->delete();
            });
            $specialization->delete();
            return Response()->json(['message' => 'Специализация удалена']);
        } else {
            return response()->json(['message' => 'Специализация не найдена']);
        }
    }

    public function deleteClient(Request $request)
    {
        $clientId = $request->input('clientId');
        $client = Client::find($clientId);
        if ($client) {
            $client->delete();
            return response()->json(['message' => 'Категория удалена']);
        } else {
            return response()->json(['message' => 'Категория не найдена']);
        }
    }

    public function deleteCategory(Request $request){
        $categoryId = $request->input('categoryId');
        $category = Category::find($categoryId);
        if ($category) {
            $category->services()->delete();
            $category->delete();
            return response()->json(['message' => 'Категория удалена'], 200);
        } else {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
    }

    public function editSpecialization(Request $request){
        $specializationId = $request->input('id');
        $newSpecializationName = $request->input('specializationName');
        $specialization = Specialization::find($specializationId);
        if ($specialization){
            $specialization->specializationName = $newSpecializationName;
            $specialization->save();
            return response()->json(['message' => 'Специализация успешно изменена'], 200);
        } else {
            return response()->json(['message' => 'Специализация не найдена'], 404);
        }
    }

    public function editClient(Request $request){
        $clientId = $request->input('id');
        $newClientName = $request->input('name');
        $newClientPhone = $request->input('phone');
        $client = Client::find($clientId);
        if ($client){
            $client->name = $newClientName;
            $client->phone = $newClientPhone;
            $client->save();
            return response()->json(['message' => 'Клиент успешно сохранен'], 200);
        } else {
            return response()->json(['message' => 'Клиент не найден']);
        }

    }

    public function editCategory(Request $request){
        $categoryId = $request->input('id');
        $newCategoryName = $request->input('category_name');
        $category = Category::find($categoryId);
        if ($category){
            $category->category_name = $newCategoryName;
            $category->save();
            return response()->json(['message' => 'Категория успешно изменена'], 200);
        } else {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
    }

    public function addNewSpecialization(Request $request)
    {
        try {
            $specializations = new Specialization();
            $specializations->specializationName = $request->input('specializationName');
            $specializations->popularCounter = 1;
            $specializations->save();
            return response()->json(['message' => 'Специализация успешно добавлена'], 200);
        } catch (\Exception $e){
            return \response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function addNewClient(Request $request){
        $clients = new Client();
        $clients->name = $request->input('name');
        $clients->phone = $request->input('phone');
        $clients->specialization_id = $request->input('specialization_id');
        $clients->save();
    }

    public function addNewCategory(Request $request){
        $categories = new Category();
        $categories->category_name = $request->input('category_name');
        $categories->specialization_id = $request->input('specialization_id');
        $categories->save();
        return response()->json(['message' => 'Категория успешно добавлена']);
    }

    public function addNewService(Request $request){
        $service = new Service;
        $service->service = $request->input('service');
        $service->price = $request->input('price');
        $service->category_id = $request->input('category_id');
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
                $service->service = $serviceName;
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

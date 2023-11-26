<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('главная страница сайта');
});

Route::get('/post/all', function (){
    return 'all';
})->name('posts');

Route::get('/user/profile', function (){
    return 'profile';
})->name('profile');
Route::get('service/show', [ServiceController::class, 'show']);
Route::get('/', [\App\Http\Controllers\HomeController::class, 'show']);
Route::get('/orders/create', 'OrdersController@create');
Route::get('/statistics', [\App\Http\Controllers\StatisticsController::class, 'index']);
Route::get('service/edit',[ServiceController::class,'editServices']);
Route::get('service/history', [ServiceController::class, 'showHistoryOrders']);
Route::get('service/statistic',[ServiceController::class, 'showStatistics']);
Route::post('/add_service', [ServiceController::class, 'addNewService']);
Route::post('/delete_service', [ServiceController::class, 'deleteService']);
Route::post('/edit_service', [ServiceController::class, 'editService']);
Route::post('/add_specialization', [ServiceController::class, 'addNewSpecialization']);
Route::post('/delete_specialization', [ServiceController::class, 'deleteSpecialization']);
Route::post('/add_category', [ServiceController::class, 'addNewCategory']);
Route::post('/delete_category', [ServiceController::class, 'deleteCategory']);
Route::post('/edit_category', [ServiceController::class, 'editCategory']);
Route::post('/edit_specialization', [ServiceController::class, 'editSpecialization']);
Route::get('/get_service/{categoryId}', [ServiceController::class, 'getServicesByCategory']);
Route::get('/get_categories/{specializationId}', [ServiceController::class, 'getCategoriesBySpecialization']);
//Route::get('/get_all_clients', [ClientController::class, 'getAllClients']);
Route::get('/get_clients/{specializationId}', [ServiceController::class, 'getClientsBySpecialization']);
Route::post('/add_client', [ServiceController::class, 'addNewClient']);
Route::post('/delete_client', [ServiceController::class, 'deleteClient']);
Route::post('/edit_client', [ServiceController::class, 'editClient']);
Route::get('/order/{orderId}', [ServiceController::class, 'showOrderDetails']);
Route::post('/save_order', [ServiceController::class, 'saveOrder']);
Route::get('/edit_order/{orderId}', [ServiceController::class, 'editOrder']);
Route::post('/update_order', [ServiceController::class, 'updateOrder']);

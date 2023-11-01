<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;

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
Route::post('/add_category', [ServiceController::class, 'addNewCategory']);
Route::post('/delete_category', [ServiceController::class, 'deleteCategory']);
Route::post('/edit_category', [ServiceController::class, 'editCategory']);
Route::get('/get_service/{categoryId}', [ServiceController::class, 'getServicesByCategory']);

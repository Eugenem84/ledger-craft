<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('главная страница сайта');
});

Route::get('/post/all', function (){
    return 'all';
})->name('posts');

Route::get('/user/profile', function (){
    return 'profile';
})->name('profile');

Route::get('/post', [PostController::class, 'show']);
//Route::get('/user', [UserController::class, 'show']);
//Route::get('/user/all', [UserController::class, 'all']);
//Route::get('/post/{id}', [PostController::class, 'show']);
//Route::get('/user/{name}', [UserController::class, 'showName']);
//Route::get('/user/{name}/{surname}', [UserController::class, 'showNameSurname']);
Route::get('user/city/{user}', [UserController::class, 'showUserCity']);
Route::get('user/view', [UserController::class, 'showView']);
Route::get('user/view2', [UserController::class, 'showView2']);
Route::get('user/view3', [UserController::class, 'showView3']);
Route::get('user/db', [UserController::class, 'showDB']);
Route::get('service/show', [ServiceController::class, 'show']);
Route::get('/', [\App\Http\Controllers\HomeController::class, 'show']);
Route::get('/orders/create', 'OrdersController@create');
Route::get('/statistics', [\App\Http\Controllers\StatisticsController::class, 'index']);
Route::get('service/edit',[ServiceController::class,'editServices']);
Route::get('service/history', [ServiceController::class, 'showHistoryOrders']);
Route::get('service/statistic',[ServiceController::class, 'showStatistics']);

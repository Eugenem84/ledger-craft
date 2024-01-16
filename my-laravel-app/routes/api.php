<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getSpecialization', [ServiceController::class, 'getSpecializations']);
Route::get('/get_service/{categoryId}', [ServiceController::class, 'getServicesByCategory']);
Route::get('/get_categories/{specializationId}', [ServiceController::class, 'getCategoriesBySpecialization']);
Route::get('/get_clients/{specializationId}', [ServiceController::class, 'getClientsBySpecialization']);
Route::post('/save_order', [ServiceController::class, 'saveOrder']);

Route::post('/add_service', [ServiceController::class, 'addNewService']);
Route::post('/delete_service', [ServiceController::class, 'deleteService']);
Route::post('/edit_service', [ServiceController::class, 'editService']);

Route::post('/add_specialization', [ServiceController::class, 'addNewSpecialization']);

Route::post('/add_client', [ServiceController::class, 'addNewClient']);
Route::post('/edit_client', [ServiceController::class, 'editClient']);
Route::post('/delete_client', [ServiceController::class, 'deleteClient']);

Route::post('/add_category', [ServiceController::class, 'addNewCategory']);



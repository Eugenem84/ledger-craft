<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientController extends Controller
{
    public function getAllClients()
    {
        $clients = Client::all();
        if ($clients){
            return response()->json($clients);

        } else {
            return response()->json(['error' => 'ошибка загрузки клиентов']);
        }
    }
}

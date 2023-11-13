<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function getAllClients(){
        $clients = Client::all();
        if ($clients) {
            return response()->json($clients);
        } else {
            return response()->json('нет клиентов');
        }
    }

    public function showClients(){
        $clients = Client::all();
        return view('service/edit', compact('clients'));
    }
}

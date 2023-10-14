<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Controllers\Controller;

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
}

<?php

namespace App\Http\Controllers;

use App\Repositories\SpecializationRepository;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    protected $specializationRepository;

    public function __construct(SpecializationRepository $specializationRepository)
    {
        $this->specializationRepository = $specializationRepository;
    }

    public function getAll()
    {
        $specializations = $this->specializationRepository->getAll();
        return response()->json($specializations);
    }
}

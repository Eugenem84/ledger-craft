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

    public function editSpecialization(Request $request)
    {
        $id = $request->input('id');
        $newSpecializationName = $request->input('specializationName');

        $result = $this->specializationRepository->editSpecialization($id, $newSpecializationName);

        if ($result){
            return response()->json(['message' => 'успешно изменено'], 200);
        } else {
            return response()->json(['message' => 'специализация не найдена'], 404);
        }
    }

}

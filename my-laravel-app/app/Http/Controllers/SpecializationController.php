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

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $newSpecializationName = $request->input('specializationName');

        $result = $this->specializationRepository->edit($id, $newSpecializationName);

        if ($result){
            return response()->json(['message' => 'успешно изменено'], 200);
        } else {
            return response()->json(['message' => 'специализация не найдена'], 404);
        }
    }

    public function addNew(Request $request)
    {
        try {
            $specializationName = $request->input('specializationName');
            $this->specializationRepository->addNew($specializationName);
            return response()->json(['message' => 'Специализация успешно добавлена'], 200);
        } catch (\Exception $e){
            return \response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function delete(Request $request){
        $id = $request->input('specializationId');
        $result = $this->specializationRepository->delete($id);
        if ($result){
            return response()->json(['message' => 'Специализация удалена']);
        } else {
            return response()->json(['message' => 'Специализация не найдена']);
        }

    }

}

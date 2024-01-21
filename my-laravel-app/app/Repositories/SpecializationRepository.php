<?php

namespace App\Repositories;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationRepository
{
    public function getAll()
    {
        return Specialization::all();
    }

    public function editSpecialization($id, $newSpecializationName)
    {
        $specialization = Specialization::find($id);
        if ($specialization){
            $specialization->specializationName = $newSpecializationName;
            $specialization->save();
            return true;
        }
        return false;
    }

}

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

    public function edit($id, $newSpecializationName)
    {
        $specialization = Specialization::find($id);
        if ($specialization){
            $specialization->specializationName = $newSpecializationName;
            $specialization->save();
            return true;
        }
        return false;
    }

    public function addNew($specializationName)
    {
        $specialization = new Specialization();
        $specialization->specializationName = $specializationName;
        $specialization->popularCounter = 1;
        $specialization->save();
    }

    public function delete($id)
    {
        $specialization = Specialization::find($id);
        if ($specialization){
            $specialization->clients()->delete();
            $specialization->categories()->each(function ($category){
                $category->services()->delete();
                $category->delete();
            });
            $specialization->delete();
            return true;
        }
        return false;
    }

}

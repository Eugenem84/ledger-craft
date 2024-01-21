<?php

namespace App\Repositories;
use App\Models\Specialization;

class SpecializationRepository
{
    public function getAll()
    {
        return Specialization::all();
    }
}

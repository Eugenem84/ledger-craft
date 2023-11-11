<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasMany(Category::class, 'specialization_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    protected $fillable = [
        'specialization_id',
    ];
}

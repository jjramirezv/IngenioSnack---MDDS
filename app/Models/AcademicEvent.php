<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];
    
    // Le decimos a Laravel que trate estos campos como Fechas (Carbon)
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
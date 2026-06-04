<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Autorizamos las columnas que se pueden llenar
    protected $fillable = ['name', 'description'];
}
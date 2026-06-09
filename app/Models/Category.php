<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Autorizamos los campos que se pueden guardar
    protected $fillable = [
        'name',
        'description'
    ];

    // Le decimos a la Categoría que "tiene muchos" Productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
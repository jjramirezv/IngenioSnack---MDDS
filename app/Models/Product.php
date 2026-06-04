<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Autorizamos las columnas que se pueden llenar desde el formulario
    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'description',
        'stock_quantity',
        'price',
        'image_path',
    ];
}
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

    // Para saber cuántas veces se ha vendido (HU07 y HU11)
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    // Para saber qué otros productos son similares (HU12)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
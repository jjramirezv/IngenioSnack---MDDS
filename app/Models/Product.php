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

    // Genera recomendaciones automáticas si este producto se queda sin stock
    public function getRecommendationsAttribute()
    {
        // Si hay stock, no necesitamos recomendar nada
        if ($this->stock_quantity > 0) {
            return collect(); 
        }

        // Si NO hay stock, buscamos productos de la misma categoría que SÍ tengan stock
        return self::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id) // Excluimos el producto actual (el agotado)
            ->where('stock_quantity', '>', 0) // Aseguramos que la recomendación sí se pueda comprar
            ->inRandomOrder() // Los rotamos para que no siempre recomiende lo mismo
            ->take(2) // Le damos máximo 2 alternativas para no abrumarlo
            ->get();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 1. Autorizamos los campos para la asignación masiva
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'cash_tendered',
    ];

    // 2. Relación con los productos (para que el attach() funcione)
    public function products()
    {
        // withPivot asegura que también podamos guardar la cantidad y el precio histórico
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }
    // Relación para saber qué alumno hizo el pedido
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relación: Un usuario puede tener muchas órdenes (pedidos)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Accesor para calcular el vuelto/cambio dinámicamente
     */
    public function getChangeDueAttribute()
    {
        return max(0, $this->cash_tendered - $this->total_amount);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Promotion;

class SellerOrderController extends Controller
{
    // Muestra la pantalla con los pedidos pendientes
    public function index()
    {
        // Traemos las órdenes pendientes, incluyendo los datos del alumno y los productos
        $orders = Order::with(['user', 'products'])
                       ->where('status', 'pending')
                       ->orderBy('created_at', 'asc') // El primero que pide, el primero que sale
                       ->get();

        return view('seller.orders.index', compact('orders'));
    }

    // Cambia el estado del pedido a "Completado" y suma recompensas
    public function complete(Order $order)
    {
        // 1. Cambiamos el estado del pedido
        $order->update(['status' => 'completed']);

        // 2. LÓGICA DE RECOMPENSAS: Sumar progreso al alumno
        $user = $order->user;
        $activePromotions = Promotion::where('is_active', true)->get();

        // Si el usuario existe (por seguridad) y hay promociones activas
        if ($user && $activePromotions->count() > 0) {
            foreach ($order->products as $product) {
                $quantityBought = $product->pivot->quantity;

                // Verificamos si el producto comprado es la "meta" de alguna promoción
                foreach ($activePromotions as $promo) {
                    if ($promo->target_product_id == $product->id) {
                        
                        // Buscamos si el alumno ya empezó a acumular puntos en esta promo
                        $userPromo = $user->promotions()->where('promotion_id', $promo->id)->first();

                        if ($userPromo) {
                            // Si ya tiene progreso, le sumamos la cantidad que acaba de comprar
                            $newProgress = $userPromo->pivot->progress + $quantityBought;
                            $user->promotions()->updateExistingPivot($promo->id, ['progress' => $newProgress]);
                        } else {
                            // Si es su primera compra para esta promo, lo registramos en la tabla pivote
                            $user->promotions()->attach($promo->id, ['progress' => $quantityBought]);
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Pedido entregado. ¡El sistema sumó los puntos automáticamente!');
    }

    public function cancel(Order $order)
    {
        // 1. Devolver el stock de cada producto al inventario
        foreach ($order->products as $product) {
            $product->increment('stock_quantity', $product->pivot->quantity);
        }

        // 2. Eliminar el pedido de la base de datos
        $order->delete();

        return back()->with('error', 'Pedido cancelado. El stock ha sido devuelto al inventario.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Promotion;

class SellerOrderController extends Controller
{
    public function index()
    {
        // 1. Los tickets que están en la cocina ahora mismo
        $orders = Order::with(['user', 'products'])
                       ->whereIn('status', ['pending', 'preparing', 'ready'])
                       ->orderBy('created_at', 'asc') 
                       ->get();

        // 2. EL PLUS: El historial de los últimos 20 pedidos procesados (entregados o cancelados)
        $historyOrders = Order::with(['user', 'products'])
                              ->whereIn('status', ['completed', 'cancelled'])
                              ->orderBy('updated_at', 'desc')
                              ->take(20)
                              ->get();

        return view('seller.orders.index', compact('orders', 'historyOrders'));
    }

    // Cambia el estado del pedido a cualquier fase
    public function updateStatus(Request $request, Order $order)
    {
        $newStatus = $request->status;

        // LÓGICA DE RECOMPENSAS: Solo si pasa a "completed" por primera vez
        if ($newStatus === 'completed' && $order->status !== 'completed') {
            $user = $order->user;
            $activePromotions = Promotion::where('is_active', true)->get();

            if ($user && $activePromotions->count() > 0) {
                foreach ($order->products as $product) {
                    $quantityBought = $product->pivot->quantity;
                    foreach ($activePromotions as $promo) {
                        if ($promo->target_product_id == $product->id) {
                            $userPromo = $user->promotions()->where('promotion_id', $promo->id)->first();
                            if ($userPromo) {
                                $newProgress = $userPromo->pivot->progress + $quantityBought;
                                $user->promotions()->updateExistingPivot($promo->id, ['progress' => $newProgress]);
                            } else {
                                $user->promotions()->attach($promo->id, ['progress' => $quantityBought]);
                            }
                        }
                    }
                }
            }
        }

        $order->update(['status' => $newStatus]);
        
        $messages = [
            'preparing' => 'El pedido ha pasado a la cocina.',
            'ready' => 'Pedido marcado como LISTO para recoger.',
            'completed' => 'Pedido entregado al estudiante con éxito.'
        ];

        return redirect()->back()->with('success', $messages[$newStatus] ?? 'Estado actualizado.');
    }

    public function cancel(Order $order)
    {
        // Evitar doble cancelación
        if ($order->status === 'cancelled') return back();

        // Devolver el stock al inventario
        foreach ($order->products as $product) {
            $product->increment('stock_quantity', $product->pivot->quantity);
        }

        // Ya no borramos el registro, solo lo marcamos cancelado para que el alumno lo vea
        $order->update(['status' => 'cancelled']);

        return back()->with('error', 'Pedido anulado. El stock regresó al inventario.');
    }
}
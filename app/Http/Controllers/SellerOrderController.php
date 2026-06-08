<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

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

    // Cambia el estado del pedido a "Completado" cuando el alumno lo recoge
    public function complete(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Pedido marcado como entregado.');
    }
}
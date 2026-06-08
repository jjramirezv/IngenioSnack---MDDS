<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ClientOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // HU05: El cliente ve si su pedido está pendiente o completado
        $misPedidos = $user->orders()->with('products')->orderBy('created_at', 'desc')->get();

        // HU09: Lógica de Fidelidad (Tarjetas de Regalo)
        // Contamos cuántos pedidos ya recogió (completados)
        $pedidosCompletados = $user->orders()->where('status', 'completed')->count();
        
        // Cada 5 compras se gana una tarjeta de regalo
        $meta = 5; 
        $progreso = $pedidosCompletados % $meta; 
        $tarjetasGanadas = floor($pedidosCompletados / $meta); 

        return view('client.orders.index', compact('misPedidos', 'pedidosCompletados', 'progreso', 'meta', 'tarjetasGanadas'));
    }
}
<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // HU16: Registro histórico de todas las órdenes ya entregadas
        $ordersHistory = Order::with('user')->where('status', 'completed')->orderBy('updated_at', 'desc')->get();
        
        // Calculamos un avance de la HU06 (Ingresos base)
        $totalIngresos = $ordersHistory->sum('total_amount');

        // HU08: Gestión de Compras (Top 5 clientes más fieles para premiarlos)
        $topClients = User::withCount('orders')
            ->has('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return view('seller.reports.index', compact('ordersHistory', 'totalIngresos', 'topClients'));
    }
}
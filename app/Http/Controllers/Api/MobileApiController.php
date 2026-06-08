<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class MobileApiController extends Controller
{
    // Retorna los pedidos pendientes en formato JSON puro para la App
    public function getPendingOrders()
    {
        $orders = Order::with(['user', 'products'])
                       ->where('status', 'pending')
                       ->orderBy('created_at', 'asc')
                       ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Pedidos recuperados correctamente',
            'total_pending' => $orders->count(),
            'data' => $orders
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\AcademicEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Traemos las órdenes con sus usuarios y PRODUCTOS (Para procesarlo en memoria)
        $ordersHistory = Order::with(['user', 'products'])
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get();
            
        $totalIngresos = $ordersHistory->sum('total_amount');
        $events = AcademicEvent::all();

        // 2. HU08: Top 5 Clientes VIP
        $topClients = User::withCount('orders')
            ->has('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        foreach ($topClients as $client) {
            $clientOrders = $ordersHistory->where('user_id', $client->id);
            $clientProducts = [];
            $clientDates = [];

            // Contamos qué compran y qué día compran más usando colecciones
            foreach ($clientOrders as $order) {
                $dateStr = Carbon::parse($order->created_at)->format('Y-m-d');
                $clientDates[$dateStr] = ($clientDates[$dateStr] ?? 0) + 1;
                
                foreach ($order->products as $product) {
                    $clientProducts[$product->name] = ($clientProducts[$product->name] ?? 0) + $product->pivot->quantity;
                }
            }

            // Calculamos su producto favorito
            if (!empty($clientProducts)) {
                arsort($clientProducts);
                $client->favorite_product = array_key_first($clientProducts);
                $client->favorite_product_qty = $clientProducts[$client->favorite_product];
            } else {
                $client->favorite_product = 'N/A';
                $client->favorite_product_qty = 0;
            }

            // Calculamos su fecha pico y evento
            if (!empty($clientDates)) {
                arsort($clientDates);
                $client->peak_date = array_key_first($clientDates);
                $client->peak_event = 'Día Normal';
                
                $pDate = Carbon::parse($client->peak_date);
                foreach ($events as $event) {
                    $start = Carbon::parse($event->start_date)->startOfDay();
                    $end = Carbon::parse($event->end_date)->endOfDay();
                    if ($pDate->between($start, $end)) {
                        $client->peak_event = $event->name;
                        break;
                    }
                }
            }
        }

        // 3. PARTE CLAVE: PATRONES DE CONSUMO (Sin errores de SQL)
        $eventInsights = [];
        foreach ($events as $event) {
            $start = Carbon::parse($event->start_date)->startOfDay();
            $end = Carbon::parse($event->end_date)->endOfDay();

            // Filtramos en memoria las ventas de esos días exactos
            $eventOrders = $ordersHistory->filter(function($order) use ($start, $end) {
                return Carbon::parse($order->created_at)->between($start, $end);
            });

            if ($eventOrders->isNotEmpty()) {
                $productCounts = [];
                // Contamos qué se vendió más
                foreach ($eventOrders as $order) {
                    foreach ($order->products as $product) {
                        $name = $product->name;
                        $qty = $product->pivot->quantity;
                        $productCounts[$name] = ($productCounts[$name] ?? 0) + $qty;
                    }
                }

                if (!empty($productCounts)) {
                    arsort($productCounts);
                    $eventInsights[] = (object)[
                        'event_name' => $event->name,
                        'product_name' => array_key_first($productCounts),
                        'quantity' => $productCounts[array_key_first($productCounts)]
                    ];
                }
            }
        }

        // 4. PARTE IA (Preparación de CSV para Python)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $historicalData = $ordersHistory->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy(function($order) {
                return Carbon::parse($order->created_at)->format('Y-m-d');
            })->map(function ($dayOrders) {
                return $dayOrders->sum('total_amount');
            });

        $dailySalesAllTime = $ordersHistory->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('Y-m-d');
        })->map(function ($dayOrders) {
            return $dayOrders->sum('total_amount');
        });

        $csvData = "ds,y,event_name\n"; 
        foreach ($dailySalesAllTime as $date => $total) {
            $eventName = '';
            $currentDate = Carbon::parse($date);
            foreach ($events as $event) {
                $start = Carbon::parse($event->start_date)->startOfDay();
                $end = Carbon::parse($event->end_date)->endOfDay();
                if ($currentDate->between($start, $end)) {
                    $eventName = $event->name;
                    break;
                }
            }
            $csvData .= "{$date},{$total},{$eventName}\n";
        }

        $predictions = [];
        $apiError = null;

        try {
            $response = Http::timeout(10)->attach(
                'file', $csvData, 'dataset.csv'
            )->post(env('AI_URL', 'http://127.0.0.1:8001') . '/predict');

            if ($response->successful()) {
                $predictions = $response->json()['predictions'] ?? [];
            } else {
                $apiError = "El motor de IA devolvió un error.";
            }
        } catch (\Exception $e) {
            $apiError = "No se pudo conectar con la IA de Python en el puerto 8001.";
        }

        // 5. Enviamos todo a la vista
        return view('seller.reports.index', compact(
            'ordersHistory', 'totalIngresos', 'topClients', 
            'historicalData', 'predictions', 'apiError', 'eventInsights'
        ));
    }
}
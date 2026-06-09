<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\AcademicEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MockSalesSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $events = AcademicEvent::all();
        
        // Buscamos un alumno para asignarle las compras (o tomamos el primero que haya)
        $student = User::where('role', 'student')->first();

        if ($products->isEmpty() || !$student) {
            $this->command->error('Necesitas tener al menos un producto y un estudiante (cliente) en la base de datos.');
            return;
        }

        $this->command->info('⏳ Iniciando máquina del tiempo... Generando 3 meses de ventas.');

        // Viajamos 90 días al pasado
        $startDate = Carbon::now()->subDays(90);
        $endDate = Carbon::now();

        $totalOrdersCreated = 0;

        // Bucle que recorre día por día hasta hoy
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            
            // LÓGICA DE NEGOCIO:
            $isWeekend = $date->isWeekend(); // Sábado o Domingo
            $isEventDay = false;

            // Revisamos si este día cae dentro de un evento (Ej: Parciales)
            foreach ($events as $event) {
                if ($date->between($event->start_date, $event->end_date)) {
                    $isEventDay = true;
                    break;
                }
            }

            // Calculamos cuántos alumnos compran ese día
            if ($isWeekend) {
                $ordersToday = rand(0, 3); // Fines de semana el kiosco casi no vende
            } elseif ($isEventDay) {
                $ordersToday = rand(15, 25); // PICO DE VENTAS: Semana de exámenes
            } else {
                $ordersToday = rand(5, 12); // Días normales de clases
            }

            // Creamos los pedidos de ese día
            for ($i = 0; $i < $ordersToday; $i++) {
                
                // 1. Creamos la orden base (con la fecha modificada al pasado)
                $order = Order::create([
                    'user_id' => $student->id,
                    'total_amount' => 0, 
                    'cash_tendered' => 0,
                    'status' => 'completed', // Tienen que estar completadas para el reporte
                    'created_at' => $date->copy()->setHour(rand(8, 17)), // Compran entre 8am y 5pm
                    'updated_at' => $date->copy()->setHour(rand(8, 17)),
                ]);

                // 2. Le metemos entre 1 y 3 productos al azar al pedido
                $orderProducts = $products->random(rand(1, 3));
                $total = 0;

                foreach ($orderProducts as $prod) {
                    $qty = rand(1, 2); // Llevan 1 o 2 unidades de ese producto
                    $order->products()->attach($prod->id, [
                        'quantity' => $qty, 
                        'price' => $prod->price
                    ]);
                    $total += ($prod->price * $qty);
                }

                // 3. Actualizamos el total a pagar y el billete con el que pagaron
                $order->update([
                    'total_amount' => $total,
                    'cash_tendered' => ceil($total / 10) * 10 // Si sale 12, pagan con billete de 20
                ]);

                $totalOrdersCreated++;
            }
        }

        $this->command->info("✅ ¡Éxito! Se generaron {$totalOrdersCreated} pedidos históricos con patrones de IA.");
    }
}
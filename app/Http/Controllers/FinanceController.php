<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Expense;
use App\Models\AcademicEvent;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class FinanceController extends Controller
{
    // HU06: Calcula Ingresos vs Egresos
    public function index()
    {
        // Sumamos solo los pedidos ya entregados
        $ingresos = Order::where('status', 'completed')->sum('total_amount');
        $egresos = Expense::sum('amount');
        $balance = $ingresos - $egresos;
        
        $expensesList = Expense::orderBy('expense_date', 'desc')->get();

        return view('seller.finance.index', compact('ingresos', 'egresos', 'balance', 'expensesList'));
    }

    // Guarda un nuevo gasto del vendedor
    public function store(Request $request)
    {
        Expense::create($request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.1',
            'expense_date' => 'required|date'
        ]));

        return back()->with('success', 'Gasto registrado correctamente.');
    }

    // HU10: Exporta las ventas a CSV en formato Prophet para la predicción de IA
    public function export()
    {
        // 1. Obtener todos los pedidos COMPLETADOS para no contar pedidos cancelados
        $orders = Order::where('status', 'completed')->orderBy('created_at')->get();
        
        // 2. Agrupar las ventas por día y sumar los ingresos totales de ese día
        $dailySales = $orders->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('Y-m-d');
        })->map(function ($dayOrders) {
            return $dayOrders->sum('total_amount'); // Sumamos el S/ de ese día
        });

        // 3. Traer el calendario inteligente
        $events = AcademicEvent::all();

        // 4. Armar el CSV con el formato exacto para Prophet (Meta)
        // ds = DateStamp (Fecha), y = Variable a predecir (Ventas), event_name = Etiqueta
        $csvData = "ds,y,event_name\n"; 

        foreach ($dailySales as $date => $total) {
            $eventName = ''; // Por defecto, es un día normal sin eventos
            
            $currentDate = Carbon::parse($date);
            
            // Verificamos si esta fecha de venta cae dentro de algún evento académico
            foreach ($events as $event) {
                if ($currentDate->between($event->start_date, $event->end_date)) {
                    $eventName = $event->name;
                    break; // Si encontramos el evento, dejamos de buscar
                }
            }
            
            // Agregamos la fila al archivo
            $csvData .= "{$date},{$total},{$eventName}\n";
        }

        // 5. Descargar el archivo automáticamente con los headers correctos
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="dataset_prediccion_prophet.csv"',
        ]);
    }
}
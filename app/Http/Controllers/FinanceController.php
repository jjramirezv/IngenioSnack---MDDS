<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Expense;

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

    // HU10: Exporta las ventas a CSV para predicción y análisis
    public function export()
    {
        $orders = Order::with('products')->where('status', 'completed')->get();
        
        $csvData = "Fecha,Total_Cobrado,Productos_Vendidos\n";
        
        foreach($orders as $order) {
            $productos = $order->products->pluck('name')->implode(' | ');
            $csvData .= "{$order->updated_at->format('Y-m-d')},{$order->total_amount},{$productos}\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="historico_ventas.csv"');
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart');

        // Si por alguna razón el carrito está vacío, lo regresamos
        if (!$cart || count($cart) == 0) {
            return redirect('/menu')->with('error', 'Tu carrito está vacío.');
        }

        // Calculamos el total
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Usamos una transacción para que, si algo falla, no se guarde nada a medias
        DB::transaction(function () use ($cart, $totalAmount) {
            
            // 1. Creamos la orden general
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'status' => 'pending', // 'pending' significa que el alumno aún no lo recoge
                'cash_tendered' => 0   // Preparado para la futura HU15
            ]);

            // 2. Guardamos el detalle de cada producto y descontamos el stock
            foreach ($cart as $id => $item) {
                // Suponiendo que tienes un método o relación para los items (Order details)
                // Si tienes una tabla order_items, se insertaría aquí. 
                // Por ahora, usaremos el método attach si usaste una relación muchos a muchos:
                $order->products()->attach($id, [
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Descontamos el stock físico del inventario
                $product = Product::find($id);
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }

            // 3. Vaciamos el carrito de la sesión
            session()->forget('cart');
        });

        // Lo regresamos al menú con un mensaje de éxito rotundo
        return redirect('/menu')->with('success', '¡Tu pedido ha sido enviado a IngenioSnack! Pasa a recogerlo.');
    }
}
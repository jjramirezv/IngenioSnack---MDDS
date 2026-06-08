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

        if (!$cart || count($cart) == 0) {
            return redirect('/menu')->with('error', 'Tu carrito está vacío.');
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $request->validate([
            'cash_tendered' => 'required|numeric|min:' . $totalAmount
        ]);

        // ==========================================
        // NUEVO: Verificación de Stock en Tiempo Real (HU14)
        // ==========================================
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            
            // Verificamos si el producto ya no existe o si la cantidad pedida supera el stock físico actual
            if (!$product || $product->stock_quantity < $item['quantity']) {
                
                // Sacamos el producto agotado del carrito en la sesión
                unset($cart[$id]);
                session()->put('cart', $cart);

                // Lo regresamos a la pantalla "Mi Pedido" con una alerta
                return redirect('/cart')->with('error', '¡Ups! Alguien acaba de comprar los últimos "' . $item['name'] . '" mientras estabas en la fila. Lo hemos retirado de tu pedido para que elijas otra cosa.');
            }
        }
        // ==========================================

        // Si pasa la prueba de stock, procesamos la compra normal
        DB::transaction(function () use ($cart, $totalAmount, $request) {
            
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'cash_tendered' => $request->cash_tendered
            ]);

            foreach ($cart as $id => $item) {
                $order->products()->attach($id, [
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Descontamos el stock
                $product = Product::find($id);
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }

            session()->forget('cart');
        });

        return redirect('/menu')->with('success', '¡Tu pedido ha sido enviado a IngenioSnack! Pasa a recogerlo.');
    }
}
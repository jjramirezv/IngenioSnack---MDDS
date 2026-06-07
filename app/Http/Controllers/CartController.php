<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] < $product->stock_quantity) {
                $cart[$product->id]['quantity']++;
            } else {
                return redirect()->back()->with('error', 'No hay más stock disponible de este producto.');
            }
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_path" => $product->image_path
            ];
        }

        // Guardamos el carrito actualizado en la sesión
        session()->put('cart', $cart);

        // Devolvemos al alumno al menú con un mensaje de éxito
        return redirect()->back()->with('success', $product->name . ' agregado al pedido.');
    }

    // Muestra la pantalla del carrito
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Elimina un producto específico del carrito
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Borra el elemento
            session()->put('cart', $cart); // Guarda el carrito actualizado
        }

        return redirect()->back()->with('success', 'Producto retirado del pedido.');
    }
}
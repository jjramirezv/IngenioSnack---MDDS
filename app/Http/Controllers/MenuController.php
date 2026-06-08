<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MenuController extends Controller
{
    public function index()
    {
        // Traemos todos los productos para la lista general
        $products = Product::all();

        // HU07 y HU11: Calculamos los 3 productos más vendidos (que tengan stock)
        $popularProducts = Product::withCount('orders')
            ->where('stock_quantity', '>', 0)
            ->orderBy('orders_count', 'desc')
            ->take(3)
            ->get();

        // HU12: Lógica de recomendación si el producto está agotado
        foreach($products as $product) {
            if($product->stock_quantity <= 0) {
                // Buscamos un producto diferente, de la misma categoría, que SÍ tenga stock
                $product->alternativa = Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->where('stock_quantity', '>', 0)
                    ->inRandomOrder() // Recomendación variada
                    ->first();
            }
        }

        // MANTENEMOS TU ESTRUCTURA: Devolvemos a 'menu.index' y pasamos ambas variables
        return view('menu.index', compact('products', 'popularProducts'));
    }
}
<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category; // Para traer las categorías
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos todos los productos
        $products = Product::all();
        
        // Retornamos la vista pasándole los productos
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Traemos las categorías de la BD para el menú desplegable
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|max:2048' // Validamos que sea una imagen
        ]);

        // Copiamos los datos del formulario
        $data = $request->all();

        // 1. Auto-generamos el SKU (Ej: PROD-A7B2X) para no molestar al vendedor
        $data['sku'] = 'PROD-' . strtoupper(Str::random(5));

        // 2. Si el vendedor subió una foto, la guardamos en la carpeta 'products'
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except(['image']);

        // Si el Sr. Julio sube una foto nueva, la actualizamos
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}

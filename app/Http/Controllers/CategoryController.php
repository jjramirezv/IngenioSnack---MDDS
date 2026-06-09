<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Traemos las categorías y contamos cuántos productos tiene cada una
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();
        return view('seller.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string'
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Categoría agregada exitosamente.');
    }

    public function destroy(Category $category)
    {
        // Regla de negocio: No borrar si hay productos asociados
        if ($category->products()->count() > 0) {
            return back()->with('error', 'No puedes eliminar una categoría que contiene productos.');
        }

        $category->delete();
        return back()->with('success', 'Categoría eliminada correctamente.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // No olvides importar el modelo

class MenuController extends Controller
{
    public function index()
    {
        // Traemos todos los productos para que el alumno elija
        $products = Product::all();
        
        return view('menu.index', compact('products'));
    }
}
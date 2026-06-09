<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Product;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        $promotions = Promotion::with(['targetProduct', 'rewardProduct'])->latest()->get();

        return view('seller.promotions.index', compact('promotions', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_product_id' => 'required|exists:products,id',
            'required_quantity' => 'required|integer|min:1',
            'reward_product_id' => 'required|exists:products,id',
        ]);

        Promotion::create([
            'name' => $request->name,
            'target_product_id' => $request->target_product_id,
            'required_quantity' => $request->required_quantity,
            'reward_product_id' => $request->reward_product_id,
            'is_active' => true
        ]);

        return back()->with('success', '¡Promoción agregada exitosamente!');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return back()->with('success', 'Promoción eliminada.');
    }
}
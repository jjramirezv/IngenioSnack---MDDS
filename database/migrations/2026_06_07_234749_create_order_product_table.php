<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            // Conectamos con la orden
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            // Conectamos con el producto
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Guardamos el detalle de la venta
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
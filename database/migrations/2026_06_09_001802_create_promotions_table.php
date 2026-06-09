<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: "Los Jueves de Café"
            $table->foreignId('target_product_id')->constrained('products')->onDelete('cascade'); // Qué debe comprar
            $table->integer('required_quantity')->default(5); // Cuántos debe comprar
            $table->foreignId('reward_product_id')->constrained('products')->onDelete('cascade'); // Qué gana
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
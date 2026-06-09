<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\ClientOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\Api\MobileApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\AcademicEventController;

// 1. Entrada principal: redirige al login solo si NO está logueado
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' ? redirect('/panel/pedidos') : redirect('/menu');
    }
    return redirect('/login');
});

// 2. Rutas Públicas (Sin autenticación)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// 3. Rutas de Autenticación (Login, Registro, etc.)
require __DIR__.'/auth.php';

// 4. Rutas protegidas por Autenticación (Clientes y Admin)
Route::middleware(['auth'])->group(function () {
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Carrito y Pedidos Cliente
    Route::resource('products', ProductController::class);
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/mis-pedidos', [ClientOrderController::class, 'index'])->name('client.orders');

    // API Móvil
    Route::prefix('api/v1')->group(function () {
        Route::get('/pedidos', [MobileApiController::class, 'getPendingOrders']);
    });
});

// 5. Rutas EXCLUSIVAS del Administrador (Don Julio)
// Aquí aplicamos el Middleware 'EnsureUserIsAdmin' que creaste
Route::middleware(['auth', 'EnsureUserIsAdmin'])->prefix('panel')->group(function () {
    
    // Pedidos
    Route::get('/pedidos', [SellerOrderController::class, 'index'])->name('seller.orders.index');
    Route::patch('/pedidos/{order}/complete', [SellerOrderController::class, 'complete'])->name('seller.orders.complete');
    Route::delete('/pedidos/{order}/cancel', [SellerOrderController::class, 'cancel'])->name('seller.orders.cancel');

    // Categorías
    Route::get('/categorias', [CategoryController::class, 'index'])->name('seller.categories.index');
    Route::post('/categorias', [CategoryController::class, 'store'])->name('seller.categories.store');
    Route::delete('/categorias/{category}', [CategoryController::class, 'destroy'])->name('seller.categories.destroy');

    // Reportes
    Route::get('/reportes', [ReportController::class, 'index'])->name('seller.reports');
    
    // Finanzas
    Route::get('/finanzas', [FinanceController::class, 'index'])->name('seller.finance.index');
    Route::post('/finanzas/gasto', [FinanceController::class, 'store'])->name('seller.finance.store');
    Route::get('/finanzas/exportar', [FinanceController::class, 'export'])->name('seller.finance.export');

    // Recompensas y Promociones (Multi-Promoción)
    Route::get('/promociones', [PromotionController::class, 'index'])->name('seller.promotions.index');
    Route::post('/promociones', [PromotionController::class, 'store'])->name('seller.promotions.store');
    Route::delete('/promociones/{promotion}', [PromotionController::class, 'destroy'])->name('seller.promotions.destroy');

    // Calendario Inteligente (Data para IA)
    Route::get('/calendario', [AcademicEventController::class, 'index'])->name('seller.events.index');
    Route::post('/calendario', [AcademicEventController::class, 'store'])->name('seller.events.store');
    Route::delete('/calendario/{event}', [AcademicEventController::class, 'destroy'])->name('seller.events.destroy');
});
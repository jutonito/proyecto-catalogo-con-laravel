<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;

// Rutas públicas o generales para los usuarios y la página principal
Route::get('/', [CatalogController::class, 'index'])->name('welcome');
Route::get('/dashboard', [CatalogController::class, 'indexuser'])->name('dashboard'); // Usuario

// Rutas protegidas por autenticación para el dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas del perfil del usuario autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para los administradores
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Dashboard del administrador
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

    // Rutas para la gestión de productos
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // Ver productos
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // Crear producto
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // Almacenar producto
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // Eliminar producto

    // Ruta para cerrar sesión de administrador
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Rutas públicas para ver productos en el catálogo
Route::get('/admin/dashboard', [ProductController::class, 'index'])->name('admin.dashboad');


// Ruta para el dashboard que muestra el catálogo
Route::get('/dashboard', [CatalogController::class, 'indexForDashboard'])->name('dashboard');






Route::post('/cart/add', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('removeFromCart');



// Rutas para autenticación
require __DIR__.'/auth.php';

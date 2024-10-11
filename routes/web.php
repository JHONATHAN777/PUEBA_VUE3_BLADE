<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/productos', [ProductController::class, 'index']);
Route::get('/create',[ProductController::class,'create'])->name('create');
Route::get('/ciudades/{id_pais}', [ProductController::class, 'getCities']);
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Definición de rutas para órdenes
Route::resource('orders', OrdersController::class); // Esto manejará todas las rutas CRUD
Route::post('orders/{id}/cancel', [OrdersController::class, 'cancel'])->name('orders.cancel'); // Mantenemos la ruta de cancelar

require __DIR__.'/auth.php';






require __DIR__.'/auth.php';

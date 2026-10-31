<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BroadcastDemoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/kasir', [CashierController::class, 'index'])
    ->name('cashier.index');

Route::get('/invoice/pdf', [
    InvoiceController::class,
    'generate'
])->name('invoice.pdf');

Route::resource('products', ProductController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/broadcast-demo', [
    BroadcastDemoController::class,
    'index'
])->name('broadcast.demo');

Route::post('/broadcast-demo/send', [
    BroadcastDemoController::class,
    'send'
])->name('broadcast.demo.send');

require __DIR__.'/auth.php';

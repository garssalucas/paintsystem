<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Oryon\OryonController;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome')->with('name', 'home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('oryon')->group(function () {
    Route::get('/', [OryonController::class, 'index'])->name('oryon.index'); 
    Route::post('/', [OryonController::class, 'store'])->name('oryon.store')->middleware('role:gerentes'); 
    Route::get('/new', [OryonController::class, 'new'])->name('oryon.new')->middleware('role:gerentes'); 
    Route::get('/importar', [OryonController::class, 'importarProdutos'])->name('oryon.importar'); 
    Route::get('/search', [OryonController::class, 'search'])->name('oryon.search');
    Route::put('/{id}', [OryonController::class, 'update'])->name('oryon.update')->middleware('role:gerentes');
    Route::get('/{id}/edit', [OryonController::class, 'edit'])->name('oryon.edit' )->middleware('role:gerentes');
    Route::delete('/{id}/destroy', [OryonController::class, 'destroy'])->name('oryon.destroy')->middleware('role:administradores');
});

require __DIR__.'/auth.php';

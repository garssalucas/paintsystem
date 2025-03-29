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
    Route::get('/', [OryonController::class, 'index'])->name('oryon.index'); // Para exibir os produtos
    Route::post('/', [OryonController::class, 'store'])->name('oryon.store'); // Para salvar o produto
    Route::get('/new', [OryonController::class, 'new'])->name('oryon.new'); // Para exibir o formulário de cadastro
    Route::get('/importar', [OryonController::class, 'importarProdutos'])->name('oryon.importar'); // Para importar os produtos
    Route::get('/search', [OryonController::class, 'search'])->name('oryon.search');
    Route::put('/{id}', [OryonController::class, 'update'])->name('oryon.update');
    Route::get('/{id}/edit', [OryonController::class, 'edit'])->name('oryon.edit' );
    Route::delete('/{id}/destroy', [OryonController::class, 'destroy'])->name('oryon.destroy')->middleware(CheckIsAdmin::class);
});

// aqui criei o middleware CheckIsAdmin para verificar se o usuário é admin e pode deletar registros mas posso usar tb para botoes

require __DIR__.'/auth.php';

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/oryon/{id}', [OryonController::class, 'update'])->name('oryon.update');
    Route::delete('/oryon/{id}/destroy', [OryonController::class, 'destroy'])->name('oryon.destroy')->middleware(CheckIsAdmin::class);
    Route::get('/oryon/{id}', [OryonController::class, 'show'])->name('oryon.show');
    Route::get('/oryon/{id}/edit', [OryonController::class, 'edit'])->name('oryon.edit' );
    Route::get('/oryon/new', [OryonController::class, 'new'])->name('oryon.new'); // Para exibir o formulário de cadastro
    Route::post('/oryon', [OryonController::class, 'store'])->name('oryon.store'); // Para salvar o produto
    Route::get('/oryon', [OryonController::class, 'index'])->name('oryon.index'); // Para exibir os produtos
    Route::get('/importar-oryon', [OryonController::class, 'importarProdutos'])->name('oryon.importar'); // Para importar os produtos
});

// aqui criei o middleware CheckIsAdmin para verificar se o usuário é admin e pode deletar registros mas posso usar tb para botoes

require __DIR__.'/auth.php';

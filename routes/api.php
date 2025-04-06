<?php

use App\Http\Controllers\Oryon\OryonControllerVue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('produtos_oryon')->group(function () {
    Route::get('/', [OryonControllerVue::class, 'index']);
    Route::post('/', [OryonControllerVue::class, 'store']);
    Route::get('/{id}', [OryonControllerVue::class, 'show']);
    Route::put('/{id}', [OryonControllerVue::class, 'update']);
    Route::delete('/{id}', [OryonControllerVue::class, 'destroy']);
});

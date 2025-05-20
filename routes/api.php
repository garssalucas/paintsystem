<?php

use App\Http\Controllers\Oryon\OryonControllerVue;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->get('/user-role', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'roles' => $request->user()?->getRoleNames(),
    ]);
});

Route::middleware(['auth:sanctum'])->prefix('produtos_oryon')->group(function () {
    Route::get('/', [OryonControllerVue::class, 'index']);
    Route::post('/', [OryonControllerVue::class, 'store']);
    Route::get('/{id}', [OryonControllerVue::class, 'show']);
    Route::put('/{id}', [OryonControllerVue::class, 'update']);
    Route::delete('/{id}', [OryonControllerVue::class, 'destroy']);
});

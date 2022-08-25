<?php

use App\Http\Controllers\Api\CategoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('categorias', CategoriaController::class)->names('api.v1.categorias');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

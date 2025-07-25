<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DescontoController;
use App\Http\Controllers\AumentoController;

// Calcular descontos do salário
Route::post('/calcular-descontos', [DescontoController::class, 'calcular']);

// Calcular aumento do salário
Route::post('/calcular-aumento', [AumentoController::class, 'calcular']);
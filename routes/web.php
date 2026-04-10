<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JoutukController;

 
Route::get('/', [JoutukController::class, 'index'])->name('joutuk.index');
Route::post('/calculate', [JoutukController::class, 'calculate'])->name('joutuk.calculate');
Route::get('/result',     [JoutukController::class, 'result'])->name('joutuk.result');

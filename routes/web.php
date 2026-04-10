<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\JoutukController;

 
Route::get('/', [JoutukController::class, 'index'])->name('joutuk.index');
Route::post('/calculate', [JoutukController::class, 'calculate'])->name('joutuk.calculate');
Route::get('/result',     [JoutukController::class, 'result'])->name('joutuk.result');
Route::get('/clear-all', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    dd('All Cleared...');
});
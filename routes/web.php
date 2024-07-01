<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoxPackController;

Route::post('/pack-products', [BoxPackController::class, 'packProducts'])->name('box-pack.pack');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/box-pack', function () {
    return view('box-packer-form');
});
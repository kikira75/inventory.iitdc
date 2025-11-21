<?php

use App\Http\Controllers\AdjusmentController;
use App\Http\Controllers\StockOpnameController;
use Illuminate\Support\Facades\Route;

Route::resource('adjusment', AdjusmentController::class, [
  'middleware' => ['auth']
]);

Route::group(['middleware' => 'auth'], function () {
  
  Route::post('update', [AdjusmentController::class, 'update'])->name('adjusment/update');
  Route::get('sendApiAdjust', [AdjusmentController::class, 'sendApiAdjust'])->name('adjusment/sendApiAdjust');

});



?>
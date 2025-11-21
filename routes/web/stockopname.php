<?php

use App\Http\Controllers\StockOpnameController;
use App\Models\StockOpname;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
  
  Route::post('stockopname/update', [StockOpnameController::class, 'update'])->name('stockopname/update');
  Route::get('sendApiStock', [StockOpnameController::class, 'sendApiStock'])->name('stockopname/sendApiStock');

});

Route::resource('stockopname', StockOpnameController::class, [
  'middleware' => ['auth']
]);




?>
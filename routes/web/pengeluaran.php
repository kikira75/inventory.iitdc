<?php

use App\Http\Controllers\PengeluaranController;
use Illuminate\Support\Facades\Route;

Route::resource('pengeluaran', PengeluaranController::class, [
  'middleware' => ['auth']
]);

Route::group(['middleware' => 'auth'], function () {
  
  Route::post('pengeluaran/update', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
  
  Route::get('sendApiPeng', [PengeluaranController::class, 'sendApiPeng'])->name('pengeluaran/sendApiPeng');

});


?>
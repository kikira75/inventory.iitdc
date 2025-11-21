<?php

use App\Http\Controllers\PemasukanController;
use App\Models\Pemasukan;
use Illuminate\Support\Facades\Route;

Route::resource('pemasukan', PemasukanController::class, [
  'middleware' => ['auth']
]);


Route::group(['middleware' => 'auth'], function () {
  
  Route::post('pemasukan/update', [PemasukanController::class, 'update'])->name('pemasukan/update');
  Route::get('sendApiPem', [PemasukanController::class, 'sendApiPem'])->name('pemasukan/sendApiPem');
  Route::get('/get-barang-data', [PemasukanController::class, 'getBarangData']);
  Route::get('/get-barang-lokasi', [PemasukanController::class, 'getBarangDataLokasi']);
  Route::get('/get-barang-dlokasi', [PemasukanController::class, 'getBarangDataDetailLokasi']);

});


?>
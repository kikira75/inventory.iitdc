<?php

use App\Http\Controllers\ListAllController;
use App\Http\Controllers\PemasukanController;
use App\Models\Pemasukan;
use Barryvdh\Debugbar\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

Route::resource('listall', ListAllController::class, [
  'middleware' => ['auth']
]);


Route::group(['middleware' => 'auth'], function () {
  
  
});




?>
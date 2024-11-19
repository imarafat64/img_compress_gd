<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ImageController::class)->group(function(){
  Route::get('image','fileUpload');
  Route::post('image','storeImage')->name('image.store');

  
});

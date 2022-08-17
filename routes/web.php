<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('home')

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('garages')->as('garages.')->group(function() {
    Route::get('/', ['App\Http\Controllers\GarageController', 'index'])->name('index');
    Route::post('/', ['App\Http\Controllers\GarageController', 'store'])->name('store');
    Route::get('{garage}', ['App\Http\Controllers\GarageController', 'show'])->name('show');
    Route::post('{garage}', ['App\Http\Controllers\GarageController', 'update'])->name('update');
    Route::post('{garage}/update-name', ['App\Http\Controllers\GarageController', 'updateName'])->name('updateName');
    Route::delete('{garage}', ['App\Http\Controllers\GarageController', 'destroy'])->name('destroy');
});

Route::prefix('slots')->as('slots.')->group(function() {
    Route::get('/{garage_id}', ['App\Http\Controllers\SlotController', 'index'])->name('index');
    Route::post('/', ['App\Http\Controllers\SlotController', 'store'])->name('store');
    Route::get('{slot}', ['App\Http\Controllers\SlotController', 'show'])->name('show');
    Route::post('{slot}', ['App\Http\Controllers\SlotController', 'update'])->name('update');
    Route::delete('{slot}', ['App\Http\Controllers\SlotController', 'destroy'])->name('destroy');
});

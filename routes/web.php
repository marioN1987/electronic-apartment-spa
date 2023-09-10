<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HousesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::get('list', [HousesController::class, 'list'])->name('getAllHouses');

Route::get('get-states', [HousesController::class, 'getStates'])->name('getHouseStates');

Route::get('load-house/{id}', [HousesController::class, 'getHouseById'])->name('loadHouse');

Route::post('/create-house', [HousesController::class, 'create'])->name('createHouse');

Route::post('/update-house', [HousesController::class, 'update'])->name('updateHouse');

Route::post('/delete-house/{id}', [HousesController::class, 'delete'])->name('deleteHouse');


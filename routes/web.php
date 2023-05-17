<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanLaptopController;


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
    return view('welcome');
});

Route::get('/laptopall',[PeminjamanLaptopController::class,'index']);
Route::post('/laptop/store',[PeminjamanLaptopController::class,'store']);
Route::get('/generate-token',[PeminjamanLaptopController::class,'generateToken']);
Route::get('/laptop/{id}', [PeminjamanLaptopController::class, 'show']);
Route::patch('/laptop/update/{id}',[PeminjamanLaptopController::class, 'update']);
Route::delete('/laptop/delete/{id}',[PeminjamanLaptopController::class, 'destroy']);
Route::get('/laptop/show/trash', [PeminjamanLaptopController::class, 'trash']);
Route::get('/laptop/trash/restore/{id}', [PeminjamanLaptopController::class, 'restore']);
Route::get('/laptop/trash/delete/permanen/{id}', [PeminjamanLaptopController::class, 'permanenDelete']);








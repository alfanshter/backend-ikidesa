<?php

use App\Http\Controllers\AktaKelahiranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\VersiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/aktakelahiran', [AktaKelahiranController::class, 'index']);

Route::post('/aktakelahiran', [AktaKelahiranController::class, 'store']);

//====== Versi Aplikasi ======//
//localhost/api/versi
Route::get('/versi', [VersiController::class, 'index']);
Route::post('/versi', [VersiController::class, 'insert']);
Route::post('/versi/{id}', [VersiController::class, 'update']);
Route::delete('/versi/{id}', [VersiController::class, 'delete']);
Route::get('/versi', [VersiController::class, 'detail']);
//====== End Versi ==========//


//====== Autentifikasi ======//
//localhost/api/auth
Route::post('/auth', [AuthController::class, 'register']);
Route::post('/checkauth', [AuthController::class, 'checkauth']);
Route::get('/auth/{uid?}', [AuthController::class, 'detailakun']);
Route::post('/update', [AuthController::class, 'update']);
//====== End Versi ==========//

//====== Akta Kelahiran ======//
//localhost/api/
Route::post('/kelahiran', [AktaKelahiranController::class, 'create']);
Route::get('/kelahiran', [AktaKelahiranController::class, 'readall']);
Route::get('/kelahiran/{uid_user}', [AktaKelahiranController::class, 'readallbyid']);
Route::get('/detailakta/{id_akta}', [AktaKelahiranController::class, 'readdetail']);
Route::post('/updateakta', [AktaKelahiranController::class, 'updateakta']);
// //====== End AktaKelahiran ==========//

//====== TRANSAKSI ======//
    /*ambil semua transaksi sesuai id */
Route::get('/transaksi/{uid?}', [TransaksiController::class, 'readtransaksi']);
    /*detail transaksi*/
Route::get('/detailtransaksi/{id?}', [TransaksiController::class, 'detailtransaksi']);
//====== END TRANSAKSI ======//

// https://ikidesa.pws-solution.com/public
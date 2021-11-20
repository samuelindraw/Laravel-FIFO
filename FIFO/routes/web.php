<?php

use App\MasterLokasi;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

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

Route::get('/', function () {return view('home');})->middleware('auth');
//Login
Route::get('/login',[LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class,'authenticate']);
Route::post('/logout',[LoginController::class,'logout']);
//register
Route::post('/register','RegisterController@store');
Route::get('/register','RegisterController@index')->middleware('guest');




//Master_Barang
Route::get('/MasterBarang/index','MasterBarangController@index')->middleware('auth');
Route::get('/MasterBarang/addBarang','MasterBarangController@create');
Route::post('/MasterBarang/addBarang','MasterBarangController@store');
Route::get('/MasterBarang/{id}','MasterBarangController@edit');
Route::post('/MasterBarang/search', 'MasterBarangController@show');
Route::patch('/MasterBarang/editBarang','MasterBarangController@update');
Route::delete('/MasterBarang/destroy/{id}','MasterBarangController@destroy' )->name('destroybarang');



//Master Lokasi
Route::get('/MasterLokasi/index','MasterLokasiController@index')->middleware('auth');
Route::get('/MasterLokasi/addLokasi','MasterLokasiController@create');
Route::post('/MasterLokasi/addLokasi','MasterLokasiController@store');
Route::get('/MasterLokasi/{id}','MasterLokasiController@edit');
Route::post('/MasterLokasi/search', 'MasterLokasiController@show');
Route::patch('/MasterLokasi/editLokasi','MasterLokasiController@update');
Route::delete('/MasterLokasi/destroy/{id}','MasterLokasiController@destroy' )->name('destroylokasi');


//item_Transaksi
Route::get('/itemTransaksi/index','itemTransaksiController@index')->middleware('auth');
Route::get('/itemTransaksi/addTransaksi','itemTransaksiController@create');
Route::post('/itemTransaksi/addTransaksi','itemTransaksiController@store');
Route::get('/itemTransaksi/{id}','itemTransaksiController@edit');
Route::post('/itemTransaksi/search', 'itemTransaksiController@show');
Route::patch('/itemTransaksi/editTransaksi','itemTransaksiController@update');
Route::delete('/itemTransaksi/destroy/{id}','itemTransaksiController@destroy' )->name('destroyTransaksi');
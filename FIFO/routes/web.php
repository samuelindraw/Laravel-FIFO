<?php

use App\Masterum;
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


//Login
Route::get('/login',[LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class,'authenticate']);
Route::post('/logout',[LoginController::class,'logout']);
//register
Route::post('/register','RegisterController@store');
Route::get('/register','RegisterController@index')->middleware('guest');



Route::group(['middleware' => 'auth'], function () {
//Master_Barang
Route::get('/', function () {return view('home');});
Route::get('/MasterBarang/index','MasterBarangController@index');
Route::get('/MasterBarang/addBarang','MasterBarangController@create');
Route::post('/MasterBarang/addBarang','MasterBarangController@store');
Route::get('/MasterBarang/{id}','MasterBarangController@edit');
Route::post('/MasterBarang/search', 'MasterBarangController@show');
Route::patch('/MasterBarang/editBarang','MasterBarangController@update');
// Route::delete('/MasterBarang/destroy/{id}','MasterBarangController@destroy' )->name('destroybarang');



//Master Lokasi
Route::get('/MasterLokasi/index','MasterLokasiController@index');
Route::get('/MasterLokasi/addLokasi','MasterLokasiController@create');
Route::post('/MasterLokasi/addLokasi','MasterLokasiController@store');
Route::get('/MasterLokasi/{id}','MasterLokasiController@edit');
Route::post('/MasterLokasi/search', 'MasterLokasiController@show');
Route::patch('/MasterLokasi/editLokasi','MasterLokasiController@update');
// Route::delete('/MasterLokasi/destroy/{id}','MasterLokasiController@destroy' )->name('destroylokasi');


//item_Transaksi
Route::get('/itemTransaksi/index','itemTransaksiController@index');
Route::get('/itemTransaksi/addTransaksi','itemTransaksiController@create');
Route::post('/itemTransaksi/addTransaksi','itemTransaksiController@store');

Route::get('/itemTransaksi/kurangTransaksi','itemTransaksiController@kurang');
Route::post('/itemTransaksi/kurangTransaksi','itemTransaksiController@kurang_proses');

Route::get('/itemTransaksi/{id}','itemTransaksiController@edit');
Route::post('/itemTransaksi/search', 'itemTransaksiController@show');
Route::patch('/itemTransaksi/editTransaksi','itemTransaksiController@update');
Route::delete('/itemTransaksi/destroy/{id}','itemTransaksiController@destroy' )->name('destroyTransaksi');
Route::post('/itemTransaksi/search', 'itemTransaksiController@show');

//MasterStok
Route::get('/Masterstok/index','MasterstokController@index');
Route::get('/Masterstok/export_excel', 'MasterstokController@export_excel');
Route::get('/Masterstok/cetak_pdf', 'MasterstokController@cetak_pdf');
Route::post('/Masterstok/search', 'MasterstokController@show');


//Master History
Route::get('/Masterhistory/index','MasterhistoryController@index');
Route::get('/Masterhistory/export_excel', 'MasterhistoryController@export_excel');
Route::post('/Masterhistory/search', 'MasterhistoryController@show');
Route::get('/Masterhistory/cetak_pdf', 'MasterhistoryController@cetak_pdf');

//MasterUm

Route::get('/Masterum/index','MasterumController@index');
Route::get('/Masterum/addum','MasterumController@create');
Route::post('/Masterum/addum','MasterumController@store');
Route::get('/Masterum/{id}','MasterumController@edit');
Route::post('/Masterum/search', 'MasterumController@show');
Route::patch('/Masterum/editum','MasterumController@update');

//historybarang
Route::get('/historybarang/index','HistorybarangController@index');
Route::post('/historybarang/restore', 'HistorybarangController@restore');

//historylokasi
Route::get('/historylokasi/index','HistorylokasiController@index');
Route::post('/historylokasi/restore', 'HistorylokasiController@restore');

//ROUTE HELPER
Route::get('getLokasi/{id}', function ($id) {
    $lokasi = App\MasterLokasi::where('id',$id)->first();
    return response()->json($lokasi);
});
Route::get('getBarang/{id}', function ($id) {
    $barang = App\MasterBarang::where('id',$id)->with('Masterum')->first();
    return response()->json($barang);
});
});


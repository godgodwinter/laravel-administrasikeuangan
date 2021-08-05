<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    return view('stisla-luar');
});


//halaman admin fixed
Route::group(['middleware' => ['auth:web', 'verified']], function() {

//DASHBOARD-MENU
Route::get('/home', 'App\Http\Controllers\adminberandaController@index');
Route::get('/dashboard', 'App\Http\Controllers\adminberandaController@index')->name('dashboard');

//TAPEL-MENU
Route::resource('admin/tapel','App\Http\Controllers\tapelController')->except(['index','store']);
Route::get('admin/tapel', 'App\Http\Controllers\tapelController@index')->name('tapel');
Route::post('admin/tapel', 'App\Http\Controllers\tapelController@store')->name('tapel.add');


//KELAS-MENU
Route::resource('admin/kelas','App\Http\Controllers\kelasController')->except(['index']);
Route::get('admin/kelas', 'App\Http\Controllers\kelasController@index')->name('kelas');


//siswa-MENU
Route::resource('admin/siswa','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/siswa', 'App\Http\Controllers\siswaController@index')->name('siswa');

//pegawai-MENU
Route::resource('admin/pegawai','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/pegawai', 'App\Http\Controllers\siswaController@index')->name('pegawai');

//pemasukan-MENU
Route::resource('admin/pemasukan','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/pemasukan', 'App\Http\Controllers\siswaController@index')->name('pemasukan');

//pengeluaran-MENU
Route::resource('admin/pengeluaran','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/pengeluaran', 'App\Http\Controllers\siswaController@index')->name('pengeluaran');


//tagihanatur-MENU
Route::resource('admin/tagihanatur','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/tagihanatur', 'App\Http\Controllers\siswaController@index')->name('tagihanatur');


//tagihansiswa-MENU
Route::resource('admin/tagihansiswa','App\Http\Controllers\siswaController')->except(['index']);
Route::get('admin/tagihansiswa', 'App\Http\Controllers\siswaController@index')->name('tagihansiswa');


// Route::get('/home', function () {
//     return view('guess/home');
// });

});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

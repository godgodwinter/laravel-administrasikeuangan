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

Route::get('/home', 'App\Http\Controllers\adminberandaController@index');
Route::get('/dashboard', 'App\Http\Controllers\adminberandaController@index')->name('dashboard');


// Route::get('/home', function () {
//     return view('guess/home');
// });

});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

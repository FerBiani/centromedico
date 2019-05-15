<?php

use Illuminate\Support\Facades\Hash;

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
    return view('auth.login');
});

Route::get('/senha/{senha}', function ($senha) {
    return Hash::make($senha);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('usuario')->group(function () {
    Route::get('listar/{nivel}', 'UsuarioController@listar');
});
Route::resource('usuario', 'UsuarioController')->except(['index']);
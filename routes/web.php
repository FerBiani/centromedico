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

Route::get('/senha/{senha}', function ($senha) {
    return Hash::make($senha);
});

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth', 'role:2'])->group(function () {

    Route::prefix('usuario')->group(function () {
        Route::get('list/{status}', 'UsuarioController@list');
    });

    Route::resource('usuario', 'UsuarioController');

});
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
use App\{Usuario, Especializacao, Consulta};

Route::get('/senha/{senha}', function ($senha) {
    return Hash::make($senha);
});

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/', 'HomeController@index')->name('home');

Route::get('get-medicos/{especializacao}', 'UsuarioController@getMedicos');

Route::middleware(['auth', 'role:2'])->group(function () {
    
    Route::prefix('usuario')->group(function () {
        Route::get('list/{status}', 'UsuarioController@list');
        Route::get('get-cidades/{uf}', 'UsuarioController@getCidades');
    });

    Route::resource('usuario', 'UsuarioController');

});


    Route::prefix('pacientes')->group(function () {

        Route::resource('consulta', 'ConsultaController');

        Route::get('horarios', function(){
            
            $data = [
                'title' => 'Meus Agendamentos',
                'consultas' => Consulta::all()
            ];
            return view('usuario.pacientes.horarios', compact('data'));
        });

        Route::get('ficha', function(){
            $data = [
                'title'   => 'Ficha Paciente',
                'usuario' =>  Usuario::find(Auth::user()->id),
            ];
            return view('usuario.pacientes.ficha', compact('data'));
        });
    });

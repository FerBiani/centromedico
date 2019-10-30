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
use App\{Usuario, Especializacao, Agendamento};

//PARA DESENVOLVIMENTO
Route::get('/senha/{senha}', function ($senha) {
    return Hash::make($senha);
});
//####################

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/', 'HomeController@index')->name('home');

Route::get('get-medicos/{especializacao}', 'UsuarioController@getMedicos');

Route::middleware(['auth', 'role:1 4'])->group(function () {
    
    Route::prefix('usuario')->group(function () {
        Route::get('list/{status}', 'UsuarioController@list');
        Route::get('get-cidades/{uf}', 'UsuarioController@getCidades');
        Route::get('relatorios', 'UsuarioController@relatorios');
        Route::get('status', 'UsuarioController@relatorioStatus');
    });

    Route::resource('usuario', 'UsuarioController');
    Route::get('agendamentos', 'AgendamentoController@index');
    Route::post('check-in', 'CheckInController@store');

});

Route::middleware(['auth', 'role:2'])->group(function () {

    Route::prefix('pacientes')->group(function () {

        //Route::resource('agendamento', 'AgendamentoController');
        // Route::get('disponibilidade/{id}', 'AgendamentoController@getDisponibilidade');
        // Route::get('dias/{id}', 'AgendamentoController@getDias');
        // Route::get('horarios', function(){
         
        Route::get('agendamentos', 'AgendamentoController@index');

        Route::get('ficha', function(){
            $data = [
                'title'   => 'Ficha Paciente',
                'usuario' =>  Usuario::find(Auth::user()->id),
            ];
            return view('usuario.pacientes.ficha', compact('data'));
        });
    });

});

Route::middleware(['auth', 'role:3'])->group(function () {

    Route::prefix('medicos')->group(function () {

        //Horário
        Route::get('horario/list', 'HorarioController@list');
        Route::resource('horario', 'HorarioController');
        Route::get('agendamentos', 'AgendamentoController@index');
        Route::post('status/{id}', 'AgendamentoController@setStatus');
    });

});

Route::middleware(['auth', 'role:4'])->group(function () {

    Route::prefix('atendente')->group(function () {

        Route::resource('agendamento', 'AgendamentoController');
        Route::get('pacientes', 'AgendamentoController@pacientes');
        Route::get('filtro','AgendamentoController@filtro');
        Route::get('confirma/{id}', 'AgendamentoController@confirma');
        Route::get('disponibilidade/{id}', 'AgendamentoController@getDisponibilidade');
        Route::get('dias/{id}', 'AgendamentoController@getDias');
    });

});

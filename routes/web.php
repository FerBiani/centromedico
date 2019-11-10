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

Route::middleware('auth')->group(function() {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('get-medicos/{especializacao}', 'UsuarioController@getMedicos');

    Route::middleware('role:1')->group(function () {

        Route::get('relatorios', 'RelatorioController@index');
        Route::get('logs', 'LogController@index');
        Route::get('logs/list', 'LogController@list');

    });

    Route::middleware('role:1 4')->group(function () {

        Route::middleware('role:1 4')->group(function () {
        
            Route::prefix('usuario')->group(function () {
                Route::get('list/{status}', 'UsuarioController@list');
            });

            Route::resource('usuario', 'UsuarioController');
            Route::get('agendamentos', 'AgendamentoController@index');
            Route::post('check-in', 'CheckInController@store');

        });
    
    });

    Route::middleware('role:2')->group(function () {

        Route::prefix('pacientes')->group(function () {
            Route::get('agendamentos', 'AgendamentoController@index');
            Route::get('ficha', 'PacienteController@index');
        });

    });

    Route::middleware('role:3')->group(function () {

        Route::prefix('medicos')->group(function () {
            Route::get('horario/list', 'HorarioController@list');
            Route::resource('horario', 'HorarioController');
            Route::get('agendamentos', 'AgendamentoController@index');
        });

        Route::prefix('atestados')->group(function() {
            Route::get('gerar/{id}', 'AtestadoController@show');
        });

    });

    Route::middleware('role:4')->group(function () {

        Route::prefix('atendente')->group(function () {
            Route::resource('agendamento', 'AgendamentoController');
            Route::get('pacientes', 'AgendamentoController@pacientes');
            Route::get('filtro','AgendamentoController@filtro');
            Route::get('confirma/{id}', 'AgendamentoController@confirma');
            Route::get('disponibilidade/{id}', 'AgendamentoController@getDisponibilidade');
            Route::get('dias/{id}', 'AgendamentoController@getDias');
        });

        Route::prefix('lista')->group(function(){
            Route::get('/', 'ListaEsperaController@index');
            Route::get('/create', 'ListaEsperaController@create');
            Route::post('/store', 'ListaEsperaController@store');
            Route::get('/list', 'ListaEsperaController@list');
        });

        Route::prefix('retorno')->group(function(){
            Route::get('/create/{id}', 'RetornoController@create');
            Route::post('/store', 'RetornoController@store');
        });

    });

    Route::middleware('role:2 4 3')->group(function() {
        Route::post('set-status/{id}', 'AgendamentoController@setStatus');
    });
});

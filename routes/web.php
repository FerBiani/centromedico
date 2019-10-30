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

Route::get('/senha/{senha}', function ($senha) {
    return Hash::make($senha);
});

Route::get('/criar-agendamento', function() {

     //Criando um agendamento de teste
     $agendamento = Agendamento::create([
        'inicio' => '2019-10-13 08:00:00',
        'fim' => '2019-10-13 09:00:00',
        'paciente_id' => 3,
        'medico_id' => 2,
        'especializacao_id' => 2,
        'codigo_check_in' => '123456'
    ]);

    return $agendamento;
});

Route::get('/criar-check-in', function() {
   return event(new App\Events\CheckInAgendamento('123456'));
});

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
});


    Route::prefix('pacientes')->group(function () {

        //Route::resource('agendamento', 'AgendamentoController');
        // Route::get('disponibilidade/{id}', 'AgendamentoController@getDisponibilidade');
        // Route::get('dias/{id}', 'AgendamentoController@getDias');
        // Route::get('horarios', function(){
         
        Route::get('agendamentos', function(){
            $data = [
                'title' => 'Meus Agendamentos',
                'consultas' => Agendamento::where('paciente_id',Auth::user()->id)->paginate(10)
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

    Route::prefix('medicos')->group(function () {

        //Horário
        Route::get('horario/list', 'HorarioController@list');
        Route::resource('horario', 'HorarioController');
        Route::get('consultas', 'HorarioController@consultas');
        Route::post('status/{id}', 'AgendamentoController@setStatus');
    });

    Route::prefix('atendente')->group(function () {

        Route::resource('agendamento', 'AgendamentoController');
        Route::get('pacientes', 'AgendamentoController@pacientes');
        Route::get('filtro','AgendamentoController@filtro');
        Route::get('confirma/{id}', 'AgendamentoController@confirma');
        Route::get('disponibilidade/{id}', 'AgendamentoController@getDisponibilidade');
        Route::get('dias/{id}', 'AgendamentoController@getDias');
    });

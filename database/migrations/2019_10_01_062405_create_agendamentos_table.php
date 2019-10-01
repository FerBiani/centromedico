<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendamentos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('data');
			$table->time('hora');
			$table->integer('paciente_id')->index('fk_agendamentos_usuarios_idx');
			$table->integer('medico_id')->index('fk_agendamentos_usuarios1_idx');
			$table->integer('especializacao_id')->index('fk_periodos_especializacoes_idx');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agendamentos');
	}

}

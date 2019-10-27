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
			$table->dateTime('inicio');
			$table->dateTime('fim');
			$table->integer('paciente_id')->index('fk_agendamentos_usuarios_idx');
			$table->integer('medico_id')->index('fk_agendamentos_usuarios1_idx');
			$table->integer('especializacao_id')->index('fk_periodos_especializacoes_idx');
			$table->string('codigo_check_in', 45);
			$table->integer('check_in_id')->unsigned()->nullable()->index('fk_agendamentos_check_in_id_idx');
			$table->integer('status_id')->unsigned()->nullable()->index('fk_agendamentos_status_id_idx');
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

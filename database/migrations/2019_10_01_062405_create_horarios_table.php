<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('horarios', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->time('inicio');
			$table->time('fim');
			$table->integer('dias_semana_id')->unsigned()->index('fk_horarios_dias_semana1_idx');
			$table->integer('usuario_id')->unsigned()->index('fk_horarios_usuarios_idx');
			$table->integer('especializacao_id')->unsigned()->index('fk_horarios_especializacoes_idx');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('horarios');
	}

}

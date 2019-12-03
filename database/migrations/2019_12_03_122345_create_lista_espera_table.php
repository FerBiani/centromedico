<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListaEsperaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lista_espera', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('paciente_id')->unsigned()->index('fk_lista_espera_usuarios_idx');
			$table->integer('dia_semana_id')->unsigned()->index('fk_lista_espera_dias_semana_idx');
			$table->integer('especializacao_id')->unsigned()->index('fk_lista_espera_especializacoes_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lista_espera');
	}

}

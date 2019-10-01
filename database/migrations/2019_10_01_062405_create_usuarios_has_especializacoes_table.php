<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsuariosHasEspecializacoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios_has_especializacoes', function(Blueprint $table)
		{
			$table->integer('usuario_id')->unsigned();
			$table->integer('especializacao_id')->index('fk_usuarios_has_especializacoes_especializacao_id_idx');
			$table->primary(['usuario_id','especializacao_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios_has_especializacoes');
	}

}

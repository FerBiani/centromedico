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
			$table->integer('usuarios_id')->unsigned()->index('fk_usuarios_has_especializacoes_usuarios1_idx');
			$table->integer('especializacoes_id')->index('fk_usuarios_has_especializacoes_especializacoes1_idx');
			$table->primary(['usuarios_id','especializacoes_id']);
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

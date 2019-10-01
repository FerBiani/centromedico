<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsuariosHasEspecializacoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('usuarios_has_especializacoes', function(Blueprint $table)
		{
			$table->foreign('usuario_id', 'fk_usuarios_has_especializacaoes_usuario_id')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('especializacao_id', 'fk_usuarios_has_especializacoes_especializacao_id')->references('id')->on('especializacoes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('usuarios_has_especializacoes', function(Blueprint $table)
		{
			$table->dropForeign('fk_usuarios_has_especializacaoes_usuario_id');
			$table->dropForeign('fk_usuarios_has_especializacoes_especializacao_id');
		});
	}

}

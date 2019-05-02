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
			$table->foreign('especializacoes_id', 'fk_usuarios_has_especializacoes_especializacoes1')->references('id')->on('especializacoes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('usuarios_id', 'fk_usuarios_has_especializacoes_usuarios1')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
			$table->dropForeign('fk_usuarios_has_especializacoes_especializacoes1');
			$table->dropForeign('fk_usuarios_has_especializacoes_usuarios1');
		});
	}

}

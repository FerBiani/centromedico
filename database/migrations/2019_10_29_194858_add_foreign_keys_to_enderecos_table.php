<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEnderecosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('enderecos', function(Blueprint $table)
		{
			$table->foreign('estado_id', 'fk_enderecos_estado_id')->references('id')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('usuario_id', 'fk_enderecos_usuarios1')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('enderecos', function(Blueprint $table)
		{
			$table->dropForeign('fk_enderecos_estado_id');
			$table->dropForeign('fk_enderecos_usuarios1');
		});
	}

}

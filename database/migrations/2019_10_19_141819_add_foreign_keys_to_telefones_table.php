<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTelefonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('telefones', function(Blueprint $table)
		{
			$table->foreign('usuario_id', 'fk_telefones_usuarios1')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('telefones', function(Blueprint $table)
		{
			$table->dropForeign('fk_telefones_usuarios1');
		});
	}

}

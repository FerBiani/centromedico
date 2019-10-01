<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCidadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cidades', function(Blueprint $table)
		{
			$table->foreign('estado_id', 'foreign_key_estado_id')->references('id')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cidades', function(Blueprint $table)
		{
			$table->dropForeign('foreign_key_estado_id');
		});
	}

}

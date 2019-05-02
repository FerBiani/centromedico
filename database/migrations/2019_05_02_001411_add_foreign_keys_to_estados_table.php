<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estados', function(Blueprint $table)
		{
			$table->foreign('pais_id', 'foreign_key_pais_id')->references('id')->on('paises')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('estados', function(Blueprint $table)
		{
			$table->dropForeign('foreign_key_pais_id');
		});
	}

}

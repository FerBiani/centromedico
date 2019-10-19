<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documentos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('tipo_documentos_id')->unsigned()->index('fk_documentos_tipo_documentos1_idx');
			$table->string('numero', 100);
			$table->integer('usuario_id')->unsigned()->index('fk_documentos_usuarios1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('documentos');
	}

}

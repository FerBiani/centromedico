<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDocumentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentos', function(Blueprint $table)
		{
			$table->foreign('tipo_documentos_id', 'fk_documentos_tipo_documentos1')->references('id')->on('tipo_documentos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('usuario_id', 'fk_documentos_usuarios1')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documentos', function(Blueprint $table)
		{
			$table->dropForeign('fk_documentos_tipo_documentos1');
			$table->dropForeign('fk_documentos_usuarios1');
		});
	}

}

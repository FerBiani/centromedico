<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEnderecosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enderecos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('cep', 10);
			$table->string('logradouro', 191);
			$table->string('bairro', 45);
			$table->string('numero', 10);
			$table->text('complemento', 65535)->nullable();
			$table->integer('usuario_id')->unsigned()->index('fk_enderecos_usuarios1_idx');
			$table->integer('cidade_id')->index('fk_enderecos_cidades1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('enderecos');
	}

}

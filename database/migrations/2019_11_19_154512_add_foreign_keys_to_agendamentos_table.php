<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAgendamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agendamentos', function(Blueprint $table)
		{
			$table->foreign('agendamento_id', 'fk_agendamentos_agendamento_id')->references('id')->on('agendamentos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('check_in_id', 'fk_agendamentos_check_in_id')->references('id')->on('check_ins')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agendamentos', function(Blueprint $table)
		{
			$table->dropForeign('fk_agendamentos_agendamento_id');
			$table->dropForeign('fk_agendamentos_check_in_id');
		});
	}

}

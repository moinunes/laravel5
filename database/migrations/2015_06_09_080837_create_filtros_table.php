<?php

/**************************************************************************
* para atualizar a estrutura da tabela execute: 
*                                           php artisan migrate:refresh   
*
***************************************************************************/

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbfiltros', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_user');
			$table->string('controller','30');
			$table->string('page','10');
			$table->string('ordem','30');
			$table->string('posicao','10');
			$table->string('filtros','255');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbfiltros');
	}

}

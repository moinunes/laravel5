<?php

/**************************************************************************
* para atualizar a estrutura da tabela execute: 
*                                           php artisan migrate:refresh   
*
***************************************************************************/

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidademedidasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbunidademedidas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sigla','2');
			$table->string('descricao','100');
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
		Schema::drop('tbunidademedidas');
	}

}

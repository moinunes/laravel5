<?php

/**************************************************************************
* para atualizar a estrutura da tabela execute: 
*                                           php artisan migrate:refresh   
*
***************************************************************************/

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration {


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbmenus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('titulo','100');
			$table->string('nome','100')->unique();
			$table->string('rota','50');
			$table->string('acao','50');
			$table->integer('id_pai')->nullable();
			$table->integer('posicao')->nullable();
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
		Schema::drop('tbmenus');
	}

}

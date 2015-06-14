<?php

/**************************************************************************
* para atualizar a estrutura da tabela execute: 
*                                           php artisan migrate:refresh   
*
***************************************************************************/

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbgrupos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('grupo','50')->unique();;
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
		Schema::drop('tbgrupos');
	}

}

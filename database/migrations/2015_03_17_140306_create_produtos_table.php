<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()	{
		Schema::create( 'produtos', function( Blueprint $table ) {
			$table->increments('id');                       
         $table->string('codigo','20')->unique();          
         $table->string('descricao','100');                  
         $table->integer('quantidade');
         $table->decimal('preco', 18, 4);
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
		Schema::drop( 'produtos' );
	}

}

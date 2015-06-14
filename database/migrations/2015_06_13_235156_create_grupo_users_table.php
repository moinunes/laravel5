<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoUsersTable extends Migration {

 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbgrupo_users', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_grupo');           
            $table->integer('id_user');           
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
        Schema::drop('tbgrupo_users');
    }

}

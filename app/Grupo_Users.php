<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo_Users extends Model {

	protected $table = 'tbgrupo_users';
   
   protected $fillable=[ 'id_grupo', 'id_user'  ];

}

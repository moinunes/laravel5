<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model {

   protected $table = 'tbpermissoes';
   protected $fillable=[ 'id_grupo', 'id_menu' ];

 

}

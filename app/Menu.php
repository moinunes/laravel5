<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

    protected $table = 'tbmenus';
    protected $fillable=[ 'titulo', 'nome', 'rota', 'acao', 'id_pai'  ];

   
}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidadesdemedida extends Model {

    protected $table = 'tunidadesdemedidas';
    protected $fillable=[ 'sigla', 'descricao' ];

}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model {

	protected $table = 'tbgrupos';
   protected $fillable=[ 'grupo', 'descricao' ];

}

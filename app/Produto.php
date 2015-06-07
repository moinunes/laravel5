<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model {

    protected $table = 'tbprodutos';
    protected $fillable=[ 'codigo', 'descricao', 'quantidade', 'preco' ];

}

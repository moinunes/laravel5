<?php
/**************************************************************************
*
* View.....: permissao_negada
* Descrição: exibe mensagem de acesso negado
*
***************************************************************************/

use App\Libraries\Infra\Infra_Permissao;

$titulo   = 'Permissões';

?>

@extends('layouts.layout_main')
@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">      
   	<!-- título -->
    	<div class="div_titulo">
      	{{$titulo}}
    	</div>         
		<div class="div_form"> 
			permissão negada
    	</div>
  	</div>
</div>

@endsection
<?php
/**************************************************************************
*
* View.....: grupos_form 
* Descrição: Cadastro de grupos
* Objetivo.: Exibir Formulário para: incluir, alterar, consultar e excluir
*
***************************************************************************/

$titulo = 'Cadastro de Grupos';

?>

@extends('layouts.layout_main')
@section('content')

<div class="row">
  <div class="col-md-10 col-md-offset-1">      
    <!-- título -->
    <div class="div_titulo">
      {{hlp_view::obter_titulo($acao)}} - {{$titulo}} 
    </div>
         
    <div class="div_form">       
     
        @if ( $acao == 'incluir' )            
            {!! Form::open( [ 'method'=>'PATCH','action'=>['GrupoController@update'],'class'=>'form-signup form-paddind']) !!}
         @else
            {!! Form::model($table,['method'=>'PATCH','action'=>['GrupoController@update',$table->id],'class'=>'form-signup form-paddind']) !!}
         @endif

          <table border="0" width="100%">          
            <tr>
              <td align="right" colspan="4">* campos obrigatórios</td>                
            </tr>
            <tr class='obrigatorio'>
              <td width="15%">Grupo*</td>    
              <td width="85%">Descrição*</td>
            </tr>
            <tr>                  
              <td> 
                <input name="acao" type="hidden" value="{{$acao}}">
                {!! Form::hidden( 'id',null ) !!}
                {!! Form::text( 'grupo', null, [ 'size' => 30, 'maxlength' => '50', $readonly ] ) !!}
             </td>
             <td>                
                {!! Form::text('descricao', null, ['size' => 50, 'maxlength' => '60', $readonly  ] ) !!}
             </td>
            </tr>
            <tr>                  
              <td colspan="5">              
              <hr class="hr1">
                <div class="pull-right"> 
                  @if ( $acao == 'consultar' )                  
                    <a href="/grupo/" class="btn btn-default">Voltar</a>
                  @else
                    <a href="/grupo/" class="btn btn-default">Cancelar</a>
                    <button type="submit" class="btn btn-success">Confirmar</button>                     
                  @endif  
                  </div> 

              </td>
              </tr>        
        </table> 
        
         {!! Form::close() !!}

     </div>

    @if ( count($errors) > 0)
      <div id="validar" class="panel panel-footer cor_branca">       
          Erros:<br />
          <ul  class="alert alert-danger">
            @foreach ( $errors->all() as $e )                     
              <li>{{ $e }}</li>
            @endforeach
          </ul>
      </div>
    @endif
     
  </div>
</div>

@endsection
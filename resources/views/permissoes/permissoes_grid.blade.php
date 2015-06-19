<?php

/**************************************************************************
*
* View.....: prmisoes_grid 
* Descrição: Cadastro de permissões
* Objetivo.: Montar Formulário de pesquisa e exibir registros na grid
*
***************************************************************************/

$titulo = 'Cadastro - Permissões';

?>

@extends('layouts.layout_main')
@section('content')

<div class="row">  
   <div class="col-md-10 col-md-offset-1">
      <div class="div_titulo">
         {{$titulo}}
      </div>
      <div class="div_grid">  
         <!-- monta os filtros para pesquisa -->
         <fieldset style="width:45%">
            <legend>Pesquisar</legend>
            {!! Form::open(['url'=>'permissao/', 'class'=>'navbar-form']) !!}
               <table class="table-responsive" width="100%" border="0">
                  <tr>
                     <td width="25%">Grupo</td>
                     <td width="75%"></td>
                  </tr> 
                  <tr>
                    <td><input  type='text' name="filtro_grupo" value="{{$filtros->filtro_grupo}}"     size="40" maxlength="40" ></td>                    
                    <td><button type="submit" class="btn btn-success">Filtrar</button></td>
                  </tr>
               </table>
            <?= Form::close();?>
         </fieldset>

    <!-- exibe a grid da pesquisa -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width='20%' align='center'>
                  <!-- exibe os links [imprimir] -->                  
                  <a href="{{ action('PermissaoController@crud',['imprimir',0]) }}"><span class="btn btn-success glyphicon glyphicon-print"></span></a>&nbsp;&nbsp;
                </th>                
                <th width='80%'><a href="/permissao/?order=grupo&posicao={{$filtros->posicao}}&page={{$filtros->page}}">Grupo</a></th>
            </tr>
        </thead>

        <tbody>
            @foreach ( $rs as $item )                   
              <tr>
                <td>
                  <!-- exibe os links [consultar,alterar,excluir] -->
                  <a href="{{ action('PermissaoController@crud',['alterar'  ,$item->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
                  
                </td>              
                <td>{{ $item->grupo }}</td>                
            </tr>
           @endforeach

        </tbody>

     </table>
     </div>    

     <div class="div_paginator">
        {!!$rs->render()!!}
     </div>


  </div>    
</div>

@endsection
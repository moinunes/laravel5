<?php

/**************************************************************************
*  
*  Cadastro de Produtos
*
***************************************************************************/

$titulo = 'Cadastro - Produtos';

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
            {!! Form::open(['url'=>'produto/', 'class'=>'navbar-form']) !!}
               <table class="table-responsive" width="100%" border="0">
                  <tr>
                     <td width="25%">Código</td>
                     <td width="65%">Descrição</td>
                     <td width="10%"></td>
                  </tr> 
                  <tr>
                    <td><input  type='text' name="filtro_codigo"    value="{{$filtros->filtro_codigo}}"    size="8"  maxlength="10" ></td>
                    <td><input  type='text' name="filtro_descricao" value="{{$filtros->filtro_descricao}}" size="30" maxlength="30" ></td>                  
                    <td><button type="submit" class="btn btn-success">Filtrar</button></td>
                  </tr>
               </table>
            <?= Form::close();?>
         </fieldset>

    <!-- exibe a grid da pesquisa -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width='10%'>
                  <!-- exibe os links [incluir,imprimir] -->
                  <a href="{{ action('ProdutoController@crud',['incluir' ,0]) }}"><span class="btn btn-success glyphicon glyphicon-plus"></span></a>&nbsp;&nbsp;
                  <a href="{{ action('ProdutoController@crud',['imprimir',0]) }}"><span class="btn btn-success glyphicon glyphicon-print"></span></a>&nbsp;&nbsp;
                </th>                
                <th width='15%'><a href="/produto/?order=codigo&posicao={{$filtros->posicao}}&page={{$filtros->page}}">Código</a></th>
                <th width='15%'><a href="/produto/?order=descricao&posicao={{$filtros->posicao}}&page={{$filtros->page}}">Descrição</a></th>                
                <th width='15%'><a href="/produto/?order=quantidade&posicao={{$filtros->posicao}}&page={{$filtros->page}}">Quantidade</a></th>   
                <th width='15%'><a href="/produto/?order=preco&posicao={{$filtros->posicao}}&page={{$filtros->page}}">Preço</a></th>   
                
            </tr>
        </thead>

        <tbody>
            @foreach ( $rs as $item )                   
              <tr>
                <td>
                  <!-- exibe os links [consultar,alterar,excluir] -->
                  <a href="{{ action('ProdutoController@crud',['consultar',$item->id]) }}"><span class="glyphicon glyphicon-search"></span></a>&nbsp;&nbsp;
                  <a href="{{ action('ProdutoController@crud',['alterar'  ,$item->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
                  <a href="{{ action('ProdutoController@crud',['excluir'  ,$item->id]) }}"><span class="glyphicon glyphicon-trash"></span></a>&nbsp;&nbsp;                  
                </td>              
                <td>{{ $item->codigo }}</td>
                <td>{{ $item->descricao }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>{{ $item->preco }}</td>               
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
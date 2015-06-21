<?php

/**************************************************************************
*
* View.....: produtos_grid 
* Descrição: Cadastro de produtos
* Objetivo.: Montar Formulário de pesquisa e exibir registros na grid
*
***************************************************************************/

use App\Libraries\Infra\Infra_Html; // provisório :  por o apelido no /var/www/laravel5/config/app.php:

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
                  <?php
                  Infra_Html::criar_link_com_permissao( 'incluir'  );
                  Infra_Html::criar_link_com_permissao( 'imprimir' );
                  ?>
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
                   <?php
                        Infra_Html::criar_link_com_permissao( 'consultar', $item->id );
                        Infra_Html::criar_link_com_permissao( 'alterar',   $item->id );
                        Infra_Html::criar_link_com_permissao( 'excluir',   $item->id );
                        ?>
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
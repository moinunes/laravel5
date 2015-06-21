<?php

/**************************************************************************
*
* View.....: grupos_grid 
* Descrição: Cadastro de grupos
* Objetivo.: Montar Formulário de pesquisa e exibir registros na grid
*
***************************************************************************/

use App\Libraries\Infra\Infra_Html; // provisório :  por o apelido no /var/www/laravel5/config/app.php:

$titulo = 'Cadastro - Grupos';

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
            {!! Form::open(['url'=>'grupo/', 'class'=>'navbar-form']) !!}
               <table class="table-responsive" width="100%" border="0">
                  <tr>
                     <td width="65%">Grupo</td>                     
                     <td width="35%"></td>
                  </tr> 
                  <tr>
                    <td><input  type='text' name="filtro_grupo" value="{{$filtros->filtro_grupo}}" size="35" maxlength="35" ></td>                    
                    <td  align="center"><button type="submit" class="btn btn-success">Filtrar</button></td>
                  </tr>
               </table>
            <?= Form::close();?>
         </fieldset>

         <!-- exibe a grid da pesquisa -->
         <table class="table table-bordered table-hover">
            <thead>
               <tr>
                  <th width='15%'>                  
                     <?php
                     Infra_Html::criar_link_com_permissao( 'incluir'  );
                     Infra_Html::criar_link_com_permissao( 'imprimir' );
                     ?>
                  </th>                
                  <th width='85%'>
                     <a href="/grupo/?order=grupo&posicao={{$filtros->posicao}}&page={{$filtros->page}}">Grupo</a>
                  </th>
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
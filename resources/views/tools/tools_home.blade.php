<?php
/**************************************************************************
*
* View.....: tools_home_blade 
* Descrição: ferramentas do sistema
*
***************************************************************************/

$titulo = 'Ferramentas do Sistema';

?>

@extends('layouts.layout_tools')
@section('content')

 <div class="row">
   <div class="col-md-10 col-md-offset-1">      
   
       <!-- título -->
      <div class="div_titulo">
         {{$titulo}} 
      </div>
   </div>
</div>


@endsection
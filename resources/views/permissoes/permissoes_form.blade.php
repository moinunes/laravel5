<?php
/**************************************************************************
*
* View.....: permissoes_form 
* Descrição: Cadastro de permissões
* Objetivo.: Exibir Formulário para: cadastrar permissões dos grupos de usuários
*
***************************************************************************/

$titulo = 'Permissoes';

//dd($table->grupo);

?>

@extends('layouts.layout_main')
@section('content')


<style type="text/css">
body {
font-family: verdana, arial;
font-size: 0.8em;
}

code {
white-space: pre;
}
</style>

<!-- start checkboxTree configuration -->



<!-- end checkboxTree configuration -->

<script>
$(document).ready(function() {
  
  $('.jquery').each(function() {
    eval($(this).html());
  });
  $('.button').button();
});
</script>

<div class="row">
  <div class="col-md-10 col-md-offset-1">      
    <!-- título -->
    <div class="div_titulo">
      {{$titulo}}
    </div>
         
    <div class="div_form">     
      {!! Form::open( [ 'method'=>'PATCH','action'=>['PermissaoController@update'],'class'=>'form-signup form-paddind']) !!}        
      <table border="0" width="100%">
        <tr>
          <td width="5%">Grupo:</td>    
          <td width="95%"  class='obrigatorio'>{{$table->grupo}}</td>    
        </tr>            
      </table> 

      <div id="tabs-1">
        
          <code class="jquery" lang="text/javascript">
        $('#tree1').checkboxTree();    
         </code>

          <ul id="tree1">
          <li><input type="checkbox"><label>Auxiliares</label>
          <ul>
          <li><input type="checkbox"><label>Produto</label>
          <ul>
          <li><input type="checkbox"><label>Incluir</label>
          <li><input type="checkbox"><label>Alterar</label>
          </ul>
          </ul>
          <ul>
          <li><input type="checkbox"><label>Cliente</label>
          <ul>
          <li><input type="checkbox"><label>Incluir</label>
          <li><input type="checkbox"><label>Alterar</label>
          <li><input type="checkbox"><label>Excluir</label>
          </ul>
          </ul>
          </li>
          <li><input type="checkbox"><label>Administrativo</label>
          <ul>
          <li><input type="checkbox"><label>Grupo</label>
          <ul>
          <li><input type="checkbox"><label>Node 2.1.1</label>
          </ul>
          <li><input type="checkbox"><label>Node 2.2</label>
          <ul>
          <li><input type="checkbox"><label>Node 2.2.1</label>
          <li><input type="checkbox"><label>Node 2.2.2</label>
          <li><input type="checkbox"><label>Node 2.2.3</label>
          <ul>
          <li><input type="checkbox"><label>Node 2.2.3.1</label>
          <li><input type="checkbox"><label>Node 2.2.3.2</label>
          </ul>
          <li><input type="checkbox"><label>Node 2.2.4</label>
          <li><input type="checkbox"><label>Node 2.2.5</label>
          <li><input type="checkbox"><label>Node 2.2.6</label>
          </ul>
          </ul>
          </ul>
          </div>



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

<script>  
   


  $( document ).ready(function() {
//     guarda_ids_selecionados();
  });
  

</script>

@endsection
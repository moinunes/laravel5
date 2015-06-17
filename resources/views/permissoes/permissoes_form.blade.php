<?php
/**************************************************************************
*
* View.....: permissoes_form 
* Descrição: Cadastro de permissões
* Objetivo.: Exibir Formulário para: cadastrar permissões dos grupos de usuários
*
***************************************************************************/

$titulo = 'Permissoes';

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
     
      {!! Form::open( [ 'method'=>'PATCH','action'=>['PermissaoController@update'],'class'=>'form-signup form-paddind']) !!}        
      
         

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
                <input type="hidden" name="acao"  value="{{$acao}}">
                <input type="hidden" name="ids_selecionados" id="ids_selecionados">
                {!! Form::hidden( 'id',null ) !!}
      
             </td>
            </tr>
           </table> 

      
        <table border="0" width="100%">   
            <tr>                  
              <td>              
              <hr class="hr1">
                <div class="pull-right"> 
                  @if ( $acao == 'consultar' )                  
                    <a href="/grupo/" class="btn btn-default">Voltar</a>
                  @else
                    <a href="/grupo/" class="btn btn-default">Cancelar</a>
                    <button type="submit" id="btn_confirmar" class="btn btn-success">Confirmar</button>                     
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

<script>  
   
   /**
   * Adiciona o id
   */
   $( "#btn_adicionar" ).click(function() {      
      var key   = $( "#sel_usuarios option:selected" ).val();
      var valor = $( "#sel_usuarios option:selected" ).text();   
      if( valor ) {
         // adiciona no sel_usuarios_selecionados
         $('#sel_usuarios_selecionados').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios').find('option:contains('+valor+')').remove();

         guarda_ids_selecionados();
      }
   });

   /**
   * Retira o id selecionado
   */
   $( "#btn_retirar" ).click(function() {      
      var key   = $( "#sel_usuarios_selecionados option:selected" ).val();
      var valor = $( "#sel_usuarios_selecionados option:selected" ).text();      
      if( valor ) {
         // adiciona no sel_usuarios
         $('#sel_usuarios').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios_selecionados').find('option:contains('+valor+')').remove();  
         guarda_ids_selecionados();
      }
   });

   /**
   * Adiciona todos os ids selecionados
   */
   $( "#btn_adicionar_todos" ).click(function() {
      $("#sel_usuarios option").each(function() {        
         var key = $(this).val();
         var valor = $(this).text();
         
         // adiciona no sel_usuarios
         $('#sel_usuarios_selecionados').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios').find('option:contains('+valor+')').remove();    
         guarda_ids_selecionados();
      });    
      
   });

   /**
   * Retira todos os ids selecionados
   */
   $( "#btn_retirar_todos" ).click(function() {
      $("#sel_usuarios_selecionados option").each(function() {        
         var key   = $(this).val();
         var valor = $(this).text();         
         // adiciona no sel_usuarios
         $('#sel_usuarios').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios_selecionados').find('option:contains('+valor+')').remove();

         guarda_ids_selecionados();
      });    
      
   });

   /**
   * guarda os ids selecionados
   */
   function guarda_ids_selecionados() {
      var key;
      var ids = '';
      $("#sel_usuarios_selecionados option").each(function() {        
         key = $(this).val();
         ids = ids + key+';';      
      });
      $('#ids_selecionados').val( ids );      
  }


  $( document ).ready(function() {
     guarda_ids_selecionados();
  });
  

</script>

@endsection
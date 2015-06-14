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
           </table> 

           <table border="0" width="100%">   
            <tr class='obrigatorio'>
              <td width="45%">Usuários</td>  
              <td width="5%">  </td>      
              <td width="45%">Usuários selecionados</td>
            </tr>
            <tr>                  
              <td> 
                <select id="sel_usuarios" name="usuarios" size='8' class="form-control" <?=$readonly?> >
                   @foreach ( $usuarios_nao_selecionados as $item )
                     <option value='{{$item->id}}'>{{$item->name}}</option>
                   @endforeach 
                </select>
              </td>              
              <td align="center"> 
                 <button type="button" id="btn_adicionar"       class="glyphicon glyphicon-chevron-right" <?=$disabled?> ></button> <br><br>
                 <button type="button" id="btn_retirar"         class="glyphicon glyphicon-chevron-left"  <?=$disabled?> ></button> <br><br>
                 <button type="button" id="btn_adicionar_todos" class="glyphicon glyphicon-forward"       <?=$disabled?> ></button> <br><br>
                 <button type="button" id="btn_retirar_todos"   class="glyphicon glyphicon-backward"      <?=$disabled?> ></button> <br><br>
              </td>
             <td>                
                <select id="sel_usuarios_selecionados" name="sel_usuarios_selecionados" size='8' class="form-control" <?=$readonly?> >
                   @foreach ( $usuarios_selecionados as $item )
                     <option value='{{$item->id}}'>{{$item->name}}</option>
                   @endforeach 
                </select>
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

<script>
  
   
   $( "#btn_adicionar" ).click(function() {      
      var key   = $( "#sel_usuarios option:selected" ).val();
      var valor = $( "#sel_usuarios option:selected" ).text();   
      if( valor ) {
         // adiciona no sel_usuarios_selecionados
         $('#sel_usuarios_selecionados').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios').find('option:contains('+valor+')').remove();    
      }      
   });

   $( "#btn_retirar" ).click(function() {      
      var key   = $( "#sel_usuarios_selecionados option:selected" ).val();
      var valor = $( "#sel_usuarios_selecionados option:selected" ).text();      
      if( valor ) {
         // adiciona no sel_usuarios
         $('#sel_usuarios').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios_selecionados').find('option:contains('+valor+')').remove();    
      }
   });

   $( "#btn_adicionar_todos" ).click(function() {
      $("#sel_usuarios option").each(function() {        
         var key = $(this).val();
         var valor = $(this).text();
         
         // adiciona no sel_usuarios
         $('#sel_usuarios_selecionados').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios').find('option:contains('+valor+')').remove();    
      });    
      
   });

   $( "#btn_retirar_todos" ).click(function() {
      $("#sel_usuarios_selecionados option").each(function() {        
         var key   = $(this).val();
         var valor = $(this).text();
         
         // adiciona no sel_usuarios
         $('#sel_usuarios').append( $('<option>', { value : key }).text(valor) );      
         // remove do sel_usuario
         $('#sel_usuarios_selecionados').find('option:contains('+valor+')').remove();    
      });    
      
   });

   function ja_selecionadoxxxxxxxxxxxxxxxxxxxxxxxx() {      
      result = false;
      var value = $( "#usuarios option:selected" ).text()
      if ($('#usuarios_selecionados option:contains('+ value +')').length) {     
        result = true;
      }
      return result;
   }

       //$('#sel_usuario').attr('disabled', false);

</script>

@endsection
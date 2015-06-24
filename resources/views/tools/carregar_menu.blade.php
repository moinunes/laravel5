<?php
/**************************************************************************
*
* View.....: carregar_menu_form 
* Descrição: Atualiza a tabela tbmenus de acordo com o menu.xml
*
***************************************************************************/

$titulo = 'Carregar Menus';

?>

@extends('layouts.layout_tools')
@section('content')

 <div class="row">
   <div class="col-md-10 col-md-offset-1">      
   
       <!-- título -->
      <div class="div_titulo">
          {{$titulo}} 
      </div>
         
      <div class="div_form">       
     
        {!! Form::open(array('url' => [ 'tools/carregar_menu', null],'method' => 'PUT')) !!}
         <table border="0" width="100%">
            <tr>
               <td align="right" colspan="4">* campos obrigatórios</td>                
            </tr>
            <tr class='obrigatorio'>
               <td width="15%">Atualiza a tabela tbmenus, de acordo com o arquivo menu.xml</td>              
            </tr>
            
         </table> 

         <table border="0" width="100%">   
            <tr>                  
               <td>              
                  <hr class="hr1">
                  <div class="pull-right"> 
                     
                        <a href="/tools/" class="btn btn-default">Cancelar</a>
                        <button type="submit" id="btn_confirmar" class="btn btn-success">Confirmar</button>                     
                     
                  </div>
               </td>
            </tr>        
         </table>         
         {!! Form::close() !!}
      </div>


@if(Session::has('mensagem'))
  <p class="alert alert-info">{{Session::get('mensagem') }}</p>
@endif

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

</script>

@endsection
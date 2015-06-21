<?php
/**************************************************************************
*
* View.....: permissoes_form 
* Descrição: Cadastro de permissões dos grupos
* Objetivo.: Exibir Formulário para: cadastrar permissões dos grupos de usuários
*
***************************************************************************/

use App\Libraries\Infra\Infra_Permissao;

$titulo   = 'Permissoes';
$id_grupo = $table->id;

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
      
      {!! Form::open(array('url' => [ 'permissao/update', null],'method' => 'PUT')) !!}
      <input type="hidden" name="acao"  value="{{$acao}}">
      <input type="hidden" id="id_grupo" name="id_grupo" value="{{$id_grupo}}">  
      <table border="0" width="100%">
        <tr>
          <td width="5%">Grupo:</td>    
          <td width="95%"  class='obrigatorio'>{{$table->grupo}}</td>    
        </tr>            
      </table> 
      
      <div id="tabs-1">
        <ul id="tree1">
          <?php
          $permissao = new infra_Permissao();
          $permissao->obter_menus_superior( $menus_superior, $id_grupo  );
          ?>
          @foreach ( $menus_superior as $superior )
            <?php $checked = $superior->permite != '' ? 'checked' : ''; ?>
            <li><input type="checkbox" id="txtPermissao_{{$superior->id_menu}}" name="txtPermissao_{{$superior->id_menu}}" {{$checked}} ><label>{{$superior->titulo}}</label>
               <?php               
               $permissao->obter_menus_itens( $menus_itens, $superior->id_menu, $id_grupo);
               ?>
               @foreach ( $menus_itens as $itens )
                 <?php $checked = $itens->permite != '' ? 'checked' : ''; ?>
                 <ul>
                   <li><input type="checkbox" id="txtPermissao_{{$itens->id_menu}}" name="txtPermissao_{{$itens->id_menu}}" {{$checked}} ><label>{{$itens->titulo}}</label>
                   <ul>
                      <?php
                      $permissao->obter_menus_itens( $sub_itens, $itens->id_menu, $id_grupo );
                      ?>
                      @foreach ( $sub_itens as $sub )
                        <?php $checked = $sub->permite != '' ? 'checked' : ''; ?>
                        <li><input type="checkbox" id="txtPermissao_{{$sub->id_menu}}" name="txtPermissao_{{$sub->id_menu}}" {{$checked}} ><label>{{$sub->titulo}}</label>
                      @endforeach     
                   </ul>
                   </li>
                 </ul>
               @endforeach
            </li>  
          @endforeach
          <br>
      </div>

      <table border="0" width="100%">   
        <tr>                  
          <td>              
            <hr class="hr1">
            <div class="pull-right"> 
               <a href="/permissao/" class="btn btn-default">Cancelar</a>
               <button type="submit" id="btn_confirmar" class="btn btn-success">Confirmar</button>
               <br><br><br><br>
            </div> 
          </td>
        </tr>        
      </table> 
      {!! Form::close() !!}      

    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tree1').checkboxTree();
  });

</script>



@endsection
<?php

namespace App\Libraries\Infra;

use DB;
use Request;
/*
* Classe para auxiliar
*
*/

class Infra_Html {
  
   /**
   * Desenha uma HTML tag link
   *
   * @param    string     acao
   * @param    int        id
   * @return   void   
   */
   public static function criar_link( $acao = 'incluir', $id = 0 ) {
      self::obter_classe( $classe, $acao );
      $url = Request::url();
      $url = "$url/$acao/$id";
      echo "<a href='$url'><span class='$classe'></span></a>&nbsp;&nbsp;";
   } // criar_link

   /**
   * Obtém a classe para o link
   */
   protected static function obter_classe( &$classe, $acao ) {
      $classe = '';
      switch ( $acao ) {
         case 'incluir':
            $classe = "btn btn-success glyphicon glyphicon-plus";
            break;

         case 'consultar':
            $classe = "glyphicon glyphicon-search";
            break;
         
         case 'alterar':
            $classe = "glyphicon glyphicon-pencil";
            break;

         case 'excluir':
            $classe = "glyphicon glyphicon-trash";
            break;
         
         case 'imprimir':
            $classe = "btn btn-success glyphicon glyphicon-print";
            break;
         
         default:            
            break;
      }
   } // obter_classe

}

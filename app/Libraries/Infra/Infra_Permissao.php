<?php

namespace App\Libraries\Infra;

use DB;
use Auth;
use Input;
use Request;

/*
* Classe Infra_Permissao
*
* @author moinunes
*
*/

class Infra_Permissao {

   /**
   * Obtém os menus superiores e Permissões
   */
   public function obter_menus_superior( &$resultado, $id_grupo ) {
   	$sql = " SELECT tbmenus.id      AS id_menu, 
                      tbmenus.titulo  AS titulo,
                      tbpermissoes.id AS permite
               FROM tbmenus
                  LEFT JOIN tbpermissoes ON (tbpermissoes.id_menu = tbmenus.id ) AND tbpermissoes.id_grupo = '{$id_grupo}'
               WHERE tbmenus.id_pai IS NULL ";               
      $resultado = DB::select( $sql );
   }  // obter_menus_superior

   /**
   * Obtém os Itens de menus superiores e Permissões
   */
   public function obter_menus_itens( &$resultado, $id_menu, $id_grupo ) {
      $resultado = DB::select( " SELECT tbmenus.id     AS id_menu, 
                                       tbmenus.titulo  AS titulo,
                                       tbpermissoes.id AS permite
                                 FROM tbmenus  
                                    LEFT JOIN tbpermissoes ON ( tbpermissoes.id_menu = tbmenus.id ) AND tbpermissoes.id_grupo = '{$id_grupo}'
                                 WHERE id_pai = :id_pai", [ 'id_pai' => $id_menu ] );
   } // obter_menus_itens

   public function tem_permissao() {
      $resultado = false;
      //$id_user = Auth::user()->id;
      $rota    = Request::segment(1);
      Infra_Permissao::obter_menu( $id_menu, $rota );
      Infra_Permissao::obter_grupos( $grupos );
      foreach ( $grupos as $indice => $item ) {
           //dd($id_menu);
          if  ( $this->permite_acesso( $item->id_grupo, $id_menu ) ) {
             $resultado = true;
             break;
          }
      }   
      return $resultado;
   }   

   protected function obter_menu( &$id_menu, $nome_menu ) {
      $resultado = DB::select( " SELECT id
                                 FROM tbmenus                                    
                                 WHERE nome = :nome", [ 'nome' => $nome_menu ] );
      //dd($nome_menu);
      $resultado = (object)$resultado[0];
      
      $id_menu = $resultado->id;
   }

   protected function obter_grupos( &$resultado ) {
      $id_user = Auth::user()->id;
      $resultado = false;
      $resultado = DB::select( " SELECT id_grupo,id_user
                                 FROM tbgrupo_users                                    
                                 WHERE id_user = :id_user", [ 'id_user' => $id_user ] );
   
      return $resultado;
   }

   protected function permite_acesso( $id_grupo, $id_menu ) {      
      $resultado = false;
      $query = DB::select( " SELECT id_grupo,id_menu
                                 FROM tbpermissoes
                                 WHERE id_grupo = :id_grupo AND id_menu = :id_menu", [ 'id_grupo' => $id_grupo, 'id_menu' => $id_menu ] );
      if ( $query ) {
         $resultado = true;
      } 
      return $resultado;
   }

} // Infra_Permissao
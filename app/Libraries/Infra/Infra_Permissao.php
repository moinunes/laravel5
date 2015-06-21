<?php

namespace App\Libraries\Infra;

use DB;
use Auth;
use Input;
use Request;
use app\User;

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

   public static function tem_permissao( $acao = null ) {      
      $resultado = false;      
      $rota      = Request::segment(1);
      
      // usuário master - acesso liberado
      $user = User::find( Auth::user()->id );
      if ( $user->master ) {
         return true;
      }

      // rotas com acesso liberado
      if ( $rota == 'home' ) {
         return true;
      }

      // verifica permissão
      Infra_Permissao::obter_menu( $id_menu, $rota, $acao );
      if ( $id_menu == '' ) {         
         print 'id_menu não encontrado';
         return false;
      }

      Infra_Permissao::obter_grupos( $grupos );      
      foreach ( $grupos as $indice => $item ) {              
         if ( self::permite_acesso( $item->id_grupo, $id_menu ) ) {
            $resultado = true;            
            break;
         }
      }   
      
      return $resultado;
   } // tem_permissao

   protected static function obter_menu( &$id_menu, $rota, $acao = null ) {
      $id_menu = '';
      if ( $acao == null ) {
         $registro = DB::select( " SELECT id FROM tbmenus WHERE rota = :rota", [ 'rota' => $rota ] );
      } else {
         $registro = DB::select( " SELECT id FROM tbmenus WHERE rota = :rota AND acao = :acao", [ 'rota' => $rota, 'acao' => $acao ] );
      }
      
      if ( $registro ) {
         $registro = (object)$registro[0];
         $id_menu = $registro->id;
         //dd($id_menu);
      }

   }

   protected static function obter_grupos( &$resultado ) {
      $id_user = Auth::user()->id;
      $resultado = false;
      $resultado = DB::select( " SELECT id_grupo,id_user
                                 FROM tbgrupo_users                                    
                                 WHERE id_user = :id_user", [ 'id_user' => $id_user ] );
   
      return $resultado;
   }

   protected static function permite_acesso( $id_grupo, $id_menu ) {      
      $resultado = false;
      $query = DB::select( " SELECT id_grupo,id_menu
                                 FROM tbpermissoes
                                 WHERE id_grupo = :id_grupo AND id_menu = :id_menu", [ 'id_grupo' => $id_grupo, 'id_menu' => $id_menu ] );
      //dd($id_menu);
      if ( $query ) {
         $resultado = true;
      } 
      return $resultado;
   }

} // Infra_Permissao
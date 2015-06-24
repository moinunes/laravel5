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
* verifica as permissões dos usuários

* @author Moisés Nunes
*
*/

class Infra_Permissao {

   /**
   * Obtém os menus superiores e Permissões
   *
   * @param    int        id do grupo
   * @return   array      resultado
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
   *
   * @param    int        id do menu
   * @param    int        id do grupo
   * @return   array      resultado
   */
   public function obter_menus_itens( &$resultado, $id_menu, $id_grupo ) {
      $resultado = DB::select( " SELECT tbmenus.id     AS id_menu, 
                                       tbmenus.titulo  AS titulo,
                                       tbpermissoes.id AS permite
                                 FROM tbmenus  
                                    LEFT JOIN tbpermissoes ON ( tbpermissoes.id_menu = tbmenus.id ) AND tbpermissoes.id_grupo = '{$id_grupo}'
                                 WHERE id_pai = :id_pai", [ 'id_pai' => $id_menu ] );
   } // obter_menus_itens


   /**
   * Valida se o usuário tem permissão de acesso
   *
   * @param    string     acao   
   * @return   boolean    
   */   
   public static function tem_permissao( $acao = null ) {
      $resultado = false;      
      $rota      = Request::segment(1);
      
      // se o usuário é "master" - o acesso é liberado
      $user = User::find( Auth::user()->id );
      if ( $user->master ) {
         return true;
      }

      // inserir aqui as "rotas" com acesso liberado.
      if ( $rota == '' || $rota == 'home' ) {
         return true;
      }

      // rota: tools somente para usuário master
      if ( $rota == 'tools' && !$user->master ) {
         return false;
      }      

      // obtém o id do menu para verificar a permissão
      Infra_Permissao::obter_id_menu( $id_menu, $rota, $acao );
      if ( $id_menu == '' ) {         
         dd( 'id_menu não encontrado - problemas na tabela: tbmenus' );
      }
      
      // verifica permissão      
      Infra_Permissao::obter_grupos_do_usuario( $grupos );      
      foreach ( $grupos as $indice => $item ) {
         if ( self::permite_acesso( $item->id_grupo, $id_menu ) ) {
            $resultado = true;            
            break;
         }
      }   
      
      return $resultado;
   } // tem_permissao

   /**
   * Obtém o id do menu a ser acessado pelo usuário logado
   *
   * @param    string     rota   
   * @param    string     acao   
   * @return   int        id do menu    
   */   
   protected static function obter_id_menu( &$id_menu, $rota, $acao = null ) {
      $id_menu = '';
      if ( $acao == null ) {
         $registro = DB::select( " SELECT id FROM tbmenus WHERE rota = :rota", [ 'rota' => $rota ] );
      } else {
         $registro = DB::select( " SELECT id FROM tbmenus WHERE rota = :rota AND acao = :acao", [ 'rota' => $rota, 'acao' => $acao ] );
      }      
      if ( $registro ) {
         $registro = (object)$registro[0];
         $id_menu = $registro->id;       
      }
   } // obter_id_menu

   /**
   * Obtém os grupos do usuário logado
   *
   * @return   array        grupos  
   */   
   protected static function obter_grupos_do_usuario( &$resultado ) {
      $id_user = Auth::user()->id;
      $resultado = false;
      $resultado = DB::select( " SELECT id_grupo,id_user
                                 FROM tbgrupo_users                                    
                                 WHERE id_user = :id_user", [ 'id_user' => $id_user ] );   
      return $resultado;
   } // obter_grupos_do_usuario

   /**
   * Verifica se o acesso está liberado
   *
   * @param    int        id do grupo
   * @param    int        id do menu
   * @return   boolean
   */   
   protected static function permite_acesso( $id_grupo, $id_menu ) {      
      $resultado = false;
      $query = DB::select( " SELECT id_grupo,id_menu
                                 FROM tbpermissoes
                                 WHERE id_grupo = :id_grupo AND id_menu = :id_menu", [ 'id_grupo' => $id_grupo, 'id_menu' => $id_menu ] );      
      if ( $query ) {
         $resultado = true;
      } 
      return $resultado;
   } // permite_acesso

} // Infra_Permissao
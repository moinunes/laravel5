<?php

namespace App\Libraries\Infra;

use DB;

/*
* Classe helper para auxiliar nas views da aplicação 
*
* @author moinunes
*
*/

class Infra_Menu {

   /**
   * Obter título
   *
   * @param  string   $acao
   * @return string
   */
   public function montar_menu() {      
      $this->obter_menus_superior( $menu_superior );
      echo '<nav id="menu-wrap">';
      echo '<ul id="menu">';
      echo '<li><a href="/">Home</a></li>';
      foreach( $menu_superior as $superior ) {         
         $this->obter_menus_itens( $menu_itens, $superior->id );         
         echo '<li><a href="#">'.$superior->titulo.'</a>';
         echo '<ul>';
         foreach( $menu_itens as $item ) {
            echo "<li><a href='/$item->rota'>".$item->titulo."</a></li>";
         }         
         echo '</ul>';
      }
      echo '<li><a href="/auth/logout">Sair</a></li>';
      echo '</ul>';
      echo '</nav>';
   }


   /**
   * Obtém os menus superiores
   */
   public function obter_menus_superior( &$resultado ) {
      $resultado = DB::select(' SELECT id, titulo FROM tbmenus WHERE id_pai is null ' );
   }   

   /**
   * Obtém os itens de menus
   */
   public function obter_menus_itens( &$resultado, $id ) {
      $resultado = DB::select(' SELECT id, titulo, rota, acao FROM tbmenus  WHERE id_pai = :id_pai', [ 'id_pai' => $id ] );
      //dd($resultado);
   }   

}

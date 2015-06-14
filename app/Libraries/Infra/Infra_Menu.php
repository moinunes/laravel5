<?php

namespace App\Libraries\Infra;

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
   public static function montar_menu() {
      echo '<nav id="menu-wrap">';
      echo '   <ul id="menu">';
      echo '      <li><a href="/">Home</a></li>
                  <li><a href="#">Cadastros</a>
                     <ul>
                        <li><a href="/unidadesmedida">Unidades de Medida</a></li>
                        <li><a href="/produtos">Produtos</a>
                     </ul>
                  </li>
                </ul>
              </nav>  
            '; 
      
   }


   /**
   * Obtém o menu
   */
   public function obter_menu( &$registro, $nome ) {       
      $registro = DB::select(' SELECT id, nome, id_pai FROM tbmenus WHERE nome = :nome', [ 'nome' => $nome ] );      
      $registro = (object)$registro[0];
   }   



   
}

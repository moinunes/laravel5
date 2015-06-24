<?php


/**************************************************************************
*
* Lê o arquivo menu.xml e atualiza a tabela tbmenus
* A leitura é baseanda no atributo "nome"
*
*
***************************************************************************/

namespace App\Libraries\tools;

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

use App\Menu;
use DB;

class Carregar_Menu {

   public $id_pai_nivel_0;
   public $id_pai_nivel_1;

   /**
   * executar
   */
   public function executar() {
   	$this->incluir_ou_alterar_menu();
	   $this->retirar_permissoes();
	   $this->excluir_menus();	   
	   $this->enumerar_posicao();

	   //dd(' final ');
	} 	// executar

   /**
   * Lê o menu.xml e inclui/altera os menus
   *
   */
   public function incluir_ou_alterar_menu() {
   	$arquivo = app_path().'/Libraries/tools/menu.xml';   	
 		$xml     = simplexml_load_file( $arquivo );
      //.. lendo nível 0      
	   foreach ( $xml->ITEM as $item ) {	   	  
         print $item['nome'].'</br>';
	   	if( $this->existe_menu( $item['nome'] ) ) {
	   		$this->alterar_menu( $item );
	   	} else {
           $this->incluir_menu( $item );
	   	}
         //.. lendo nível 1
	   	foreach ( $item->ITEM as $item ) {	   		
         	print $item[ 'nome' ].'</br>';	   		
	   		if( $this->existe_menu( $item['nome'] ) ) {
	   		   $this->alterar_menu( $item );
	   	   } else {
              $this->incluir_menu( $item );
	   	   }	   	
            //.. lendo nível 2
				foreach ( $item->ITEM as $item ) {					
         		print $item[ 'nome' ].'</br>';	   			
					if( $this->existe_menu( $item['nome'] ) ) {
	   		   	$this->alterar_menu( $item );
	   	   	} else {
              		$this->incluir_menu( $item );
	   	   	}		   	
				}

	   	}
  	 	}
	} // incluir_alterar_menu

   /**
   * verifica se existe o menu
   */
   public function existe_menu( $nome ) { 
      $resultado = false;
      $registro = DB::select(' SELECT id FROM tbmenus WHERE nome = :nome', [ 'nome' => $nome ] );
      if( $registro ) {
      	$resultado = true;
      }      
      return $resultado;
   }   

	/**
   * Obtém o menu
   */
   public function obter_menu( &$registro, $nome ) {       
      $registro = DB::select(' SELECT id, nome, id_pai FROM tbmenus WHERE nome = :nome', [ 'nome' => $nome ] );      
      $registro = (object)$registro[0];
   }   

   /**
   * inclui o item de menu
   */
   public function incluir_menu( $item ) {   	   	
   	$menu = new Menu;      
      $menu->titulo = utf8_decode($item['titulo']);
      $menu->nome   = utf8_decode($item['nome']);
      if ( $item['nivel'] == "1" ) {
         $menu->rota = $item['rota'];
      }
      if ( $item['nivel'] == "2" ) {
      	$menu->rota   = $item['rota'];
      	$menu->acao   = $item['acao'];
      }      
      if ( $item['nivel'] == "1" ) {
      	$menu->id_pai = $this->id_pai_nivel_0;
      } else if ( $item['nivel'] == "2" ) {
      	$menu->id_pai = $this->id_pai_nivel_1;
      }
      $menu->save();

      // guarda o nível
      if ( $item['nivel'] == "0" ) {
      	$this->id_pai_nivel_0 = $menu->id;
      } else if ( $item['nivel'] == "1" ) {
      	$this->id_pai_nivel_1 = $menu->id;
      }
 	}

 	/**
   * altera o item de menu
   */
   public function alterar_menu( $item ) {
      // guarda o nível
      $this->obter_menu( $menu, $item['nome'] );      
      if ( $item['nivel'] == "0" ) {
      	$this->id_pai_nivel_0 = $menu->id;
      } else if ( $item['nivel'] == "1" ) {
      	$this->id_pai_nivel_1 = $menu->id;
      }      
      $sql  = " UPDATE tbmenus SET titulo = '{$item['titulo']}', rota = '{$item['rota']}', acao = '{$item['acao']}' ";
      $sql .= " WHERE nome = '{$item['nome']}' ";
      DB::update( $sql );
 	}	

   /**
   * Lê o menu.xml e enumera a posição
   *
   */
   public function enumerar_posicao() {
   	$arquivo = app_path().'/Libraries/tools/menu.xml';   	
 		$xml     = simplexml_load_file( $arquivo );
 		$pos0 = 0; 		
 		//.. lendo nível 0
	   foreach ( $xml->ITEM as $item ) {
	   	$pos1 = 0;	   	
         print $item['nome'].'</br>';         
	   	$this->alterar_posicao( $item['nome'], ++$pos0 ); 
         //.. lendo nível 1
	   	foreach ( $item->ITEM as $item ) {
	   		$pos2 = 0;	   		
         	print $item[ 'nome' ].'</br>';	   		
	   		$this->alterar_posicao( $item['nome'], ++$pos1 ); 
	   	   //.. lendo nível 2
				foreach ( $item->ITEM as $item ) {					
         		print $item[ 'nome' ].'</br>';	   			
			      $this->alterar_posicao( $item['nome'], ++$pos2 ); 
				}
	   	}

  	 	}
	} // enumerar posicao

   /**
   * altera a posicao do menu
   */
   public function alterar_posicao( $nome, $posicao ) {
   	//dd($nome. $posicao);   	       
      $sql  = " UPDATE tbmenus SET posicao = '{$posicao}' WHERE nome = '{$nome}' ";
      DB::update( $sql );
 	}	// alterar_posicao

   /**
   * Excluir os menus(itens) retirados do menu.xml
   *
   */
   public function excluir_menus() {   	
   	$this->obter_nomes_menus_xml( $nomes_xml );   	
   	$this->obter_menus( $menus );
   	foreach ( $menus as $index => $item ) {
   		 if ( !in_array( $item->nome, $nomes_xml ) ) {
         	Menu::find( $item->id )->delete();
         }		
   	}
 	} // excluir_menus

   /**
   * Retira permissões dos itens que foram excluídos do menu.xml
   *
   */
   public function retirar_permissoes() {
   	$this->obter_nomes_menus_xml( $nomes_xml );
   	$this->obter_menus( $menus );
   	foreach ( $menus as $index => $item ) {
   		if ( !in_array( $item->nome, $nomes_xml ) ) {    		           	
         	$sql  = " DELETE FROM tbpermissoes WHERE id_menu = '{$item->id}' ";
            DB::delete( $sql );
         }		
   	}
 	} // excluir_menus

   /**
   * Obtém os nomes dos menus(itens) do menu.xml
   *
   */
   public function obter_nomes_menus_xml( &$nomes ) {
   	$nomes = array();
   	$arquivo = app_path().'/Libraries/tools/menu.xml';   	
 		$xml     = simplexml_load_file( $arquivo );      
      foreach ( $xml->ITEM as $item ) {
      	array_push( $nomes, (string)$item['nome'] );      
	      foreach ( $item->ITEM as $item ) {
      		array_push( $nomes, (string)$item['nome'] );      
				foreach ( $item->ITEM as $item ) {         		
		   		array_push( $nomes, (string)$item['nome'] );
   			}
	   	}
  	 	}
	} // obter_nomes_menus

   /**
   * Obtém os menus(itens)
   */
   public function obter_menus( &$registro ) {       
      $registro = DB::select(' SELECT id, nome FROM tbmenus' );      
   }   

}


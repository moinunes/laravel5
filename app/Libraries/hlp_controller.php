<?php

namespace App\Bibliotecas;

use Session;
use DB;
use Auth;
use Request;

/*
* Classe helper para auxiliar nos Filtros das tabelas do BD
*
* @author moinunes
*/

class hlp_controller extends \Eloquent {   
   /**
   *  Nome da tabela  
   */
   public $nome_tabela;
   
   public $total_registros = 4;   
   
   /**
   * Create a new controller instance.
   * @return void
   */
   public function __construct() {
      
   }

   
   /**
   * guarda os filtros em sessão
   * 
   * param array
   * 
   * @return string
   */
   public function set_session( $data  ) {
      $nome_controller   = Request::segment(1);
      $filtros = new \stdClass();   
      
      
      //print '<pre>'; print_r( $data);
      
      //print '<pre>'; print_r( $data->filtros);die();
      
      foreach ( $data->filtros as $index => $valor ) {
        $filtros->$index = $valor;
      }
      //print '<pre>'; print_r( $filtros);
      $data->filtros = $filtros;
      $data->total_registros = $this->total_registros;
      
      //print '<pre>'; print_r( $data);die();
            
      $parametros = array( $nome_controller => $data );            
     
      
     // print '<pre>'; print_r( $parametros);die();
      
      Session::put( 'guardar_filtros', $parametros ); 
   }
   
   /**
   * Obtém a sessao
   * 
   * @return array
   */   
      public function get_session() {
      $nome_controller = Request::segment(1);      
      $nome_sessao = session('guardar_filtros');
      $nome_sessao = $nome_sessao[ $nome_controller];
      //print '<pre>'; print_r(  $nome_sessao );
      return $nome_sessao;
      //print '<pre>'; print_r(  $nome_sessao );die();
   }
   
   /**
   * Obtém a sessao
   * 
   * @return array
   */   
   public function obter_valores_filtros( &$filtros, $valores = null ) {
      $filtros = new \stdClass();      
            
      foreach ( $valores as $indice => $valor ) {         
         $filtros->$indice = $valor;
      }  
      
            
     // print '<pre>'; print_r( $filtros ); die('cccccccccccc');
   }
   
}
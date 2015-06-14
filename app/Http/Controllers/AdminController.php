<?php 

/**************************************************************************
* AdminController
* 
* objetivo: 1) Verifica se o usuário está logado
*           2) prepara os filtros digitados pelo usuário
*  
*
***************************************************************************/

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;

use Input;
use Request;
use DB;
use Auth;
use View;

define( "WHERE_TODOS_REGISTROS", '1=1' );
define( "WHERE_NENHUM_REGISTRO", '1=2' );

class AdminController extends Controller {
   
   /**
   * Define os nomes dos filtros
   */   
   public $nomes_filtros;

   /**
   * Define os filtros
   */   
   public $filtros;   
   
   /**
   * Define o total de registro do paginator
   */   
   public $total_registros = 5;

   /**
   * Create a new controller instance.
   * @return void
   */
   public function __construct() {      
      // se o usuário não tiver logado, redireciona para o login
      $this->middleware( 'auth' );
   }

   /**
   * Prepara os filtros
   * @return void
   */
   public function preparar_filtros() {
      $this->obter_filtros( $filtros );
      $this->guardar_filtros( $filtros );
      $this->set_filtros();
   }

   /**
   * Obtém os filtros digitados pelo usuário
   * 
   * @return  (object)$filtros
   */   
   public function obter_filtros( &$filtros ) {
      $filtros        = new \stdClass();
      $campos_filtros = '';
      $filtros->novo_filtro = false;
      if ( Input::get('_token') != '' ) {
         $filtros->novo_filtro = true;
         foreach ( Input::get() as $index => $valor ) {
            if( substr( $index, 0, 6 ) == 'filtro' ) {
               $campos_filtros .= "{$index}=>{$valor};";               
            }
         }         
      } else {
         $campos_filtros = '';      
      }
      $filtros->filtros = $campos_filtros       != '' ? $campos_filtros       : '';
      $filtros->order   = Input::get('order')   != '' ? Input::get('order'  ) : '';
      $filtros->posicao = Input::get('posicao') != '' ? Input::get('posicao') : '';
      $filtros->page    = Input::get('page')    != '' ? Input::get('page'   ) : '';
   }
  
   /**
   * Guarda os filtros no db
   * 
   * @return void
   */      
   function guardar_filtros( $obj_filtros ) {
      $nome_controller = Request::segment(1);
      $id_user         = Auth::user()->id;
      $registro = DB::select(' SELECT * FROM tbfiltros 
                               WHERE id_user = :id_user AND controller = :controller' , 
                                     [ 'id_user' =>  $id_user, 'controller' => $nome_controller  ] );      
      if( $registro ) {
         $registro = $registro[0];
         $filtros = $obj_filtros->filtros != ''    ? $obj_filtros->filtros : $registro->filtros;
         $ordem   = $obj_filtros->order   != ''    ? $obj_filtros->order   : $registro->ordem;                  
         if ( $obj_filtros->novo_filtro ) {         
            $posicao = 'asc';
            $page    = 1;
         } else {    
            $posicao = $obj_filtros->posicao == 'asc' ? 'desc' : 'asc';
            $page    = $obj_filtros->page    != ''    ? $obj_filtros->page : $registro->page;
         }
         $sql  = " UPDATE tbfiltros SET page = '{$page}', filtros = '{$filtros}', ordem = '{$ordem}', posicao = '{$posicao}' ";
         $sql .= " WHERE id_user = '{$id_user}' AND controller = '{$nome_controller}' ";      
         DB::update( $sql );
      } else {
         DB::insert( 'INSERT INTO tbfiltros ( id_user, page, ordem, posicao, filtros, controller )
                      VALUES ( ?,?,?,?,?,? )', [Auth::user()->id,'1','id','asc',$this->nomes_filtros , $nome_controller] );
      }
   }   
   
   /**
   * Seta os filtros em memória
   * 
   * @return void
   */   
   public function set_filtros() {
      $nome_controller = Request::segment(1);
      $this->filtros   = new \stdClass();      
      $this->filtros->tem_filtro = false;
      $id_user  = Auth::user()->id;      
      $registro = DB::select(' SELECT * FROM tbfiltros 
                               WHERE id_user = :id_user AND controller = :controller' , 
                                     [ 'id_user' =>  $id_user, 'controller' => $nome_controller  ] );      
      $registro = $registro[0];
      $registro->filtros = substr( $registro->filtros, 0, strlen($registro->filtros)-1 );      
      $array_filtros = explode( ';', $registro->filtros  ) ;
      foreach ( $array_filtros as $index => $valor ) {
         $array_filtro = explode( '=>', $valor  ) ;         
         $this->filtros->$array_filtro[0] = $array_filtro[1];
         if ( $array_filtro[1] ) {
            $this->filtros->tem_filtro = true;
         };
      }
      $this->filtros->order   = $registro->ordem;
      $this->filtros->posicao = $registro->posicao;
      $this->filtros->page    = $registro->page;
      $this->set_current_page( $this->filtros->page );
   }
   
   /**
   * Seta a pagina corrente do paginador
   * 
   * @return void
   */   
   public function set_current_page( $page ) {
      Paginator::currentPageResolver( function() use ( $page ) { return $page; });
   }
   
   /**
   * Obtém o Where com os campos do filtro
   * 
   * @return    string   $where
   */   
   public function obter_where( &$where ) {
      $nome_controller = Request::segment(1);
      $where = '';
      $id_user  = Auth::user()->id;
      $registro = DB::select(' SELECT filtros FROM tbfiltros 
                               WHERE id_user = :id_user AND controller = :controller' , 
                                     [ 'id_user' =>  $id_user, 'controller' => $nome_controller  ] );      
      $registro = $registro[0];      
      $filtros  = substr( $registro->filtros, 0, strlen($registro->filtros)-1 );
      $array_filtros = explode( ';', $filtros  ) ;      
      foreach ( $array_filtros as $index => $valor ) {
         $array_filtro = explode( '=>', $valor  );
         if ( $array_filtro[1] ) {
            $campo = str_replace('filtro_', '', $array_filtro[0] );
            $where .= "$campo LIKE '%$array_filtro[1]%' AND ";
         };
      }      
      $where = substr( trim($where), 0, strlen(trim($where))-3 );
   }
   
   /**
   * Obtém Order
   * 
   * @return    string   $where
   */   
   public function obter_order( &$order ) {
      $nome_controller = Request::segment(1);
      $where = '';
      $id_user  = Auth::user()->id;
      $registro = DB::select(' SELECT ordem, posicao FROM tbfiltros 
                               WHERE id_user = :id_user AND controller = :controller' , 
                                     [ 'id_user' =>  $id_user, 'controller' => $nome_controller  ] );      
      $registro = $registro[0];
      $order = $registro->ordem.' '.$registro->posicao;
   }
   
}
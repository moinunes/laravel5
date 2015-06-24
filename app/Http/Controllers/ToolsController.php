<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use Auth;
use Redirect;

use Input;

use App\Libraries\tools\carregar_menu;


class ToolsController extends Controller {

   /**
   * Construtor padrão   
   */
   public function __construct() {  
         
       $this->middleware( 'auth' );
   }


   /**
   * index
   */
   public function index() {
      //dd('xx');
      //return view( 'tools.carregar_menu' )->with( 'acao', 'alterar' );                                         
      return view( 'tools.tools_home' )->with( 'acao', 'alterar' );                                         
   }

   /**
   * show
   */
   public function show() {
      $ferramenta = Request::segment(2);
      if( $ferramenta == 'carregar_menu' ) {
          return view( 'tools.carregar_menu' );        

      } else if( $ferramenta == 'teste' ) {
         die('teste');
      }

   }

   /**
   * update
   */
   public function update() {
      $ferramenta = Request::segment(2);
      if( $ferramenta == 'carregar_menu' ) {
          $this->carregar_menu();
          return redirect::to( 'tools/carregar_menu' )->with( 'mensagem', 'Operação realizada com sucesso.' );  

      } else if( $ferramenta == 'teste' ) {
         die('teste');
      }     
   }
   
   /**
   * Carrega o menu.xml
   */
   public function carregar_menu() {     
      $carregar_menu = new Carregar_Menu();
      $carregar_menu->executar();      
   }
   
   
}

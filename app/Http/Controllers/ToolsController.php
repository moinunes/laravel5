<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;

use Input;

use App\Libraries\tools\carregar_menu;


class ToolsController extends Controller {

   /**
   * index
   */
   public function index() {
      print "Ferramentas disponíveis:<br>";
      print '/carregar_menu';
   }

   /**
   * show
   */
   public function show() {
      $ferramenta = Request::segment(2);
      if( $ferramenta == 'carregar_menu' ) {
        $this->carregar_menu();        
      }

   }

   /**
   * Carrega o menu.xml
   */
   public function carregar_menu() {
      //hlp_view::obter_titulo($acao);
      $carregar_menu = new Carregar_Menu();
      $carregar_menu->executar();
      die( ' final ');
   }
   

}

<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\Grupo_Users;
use App\Permissao;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;

use Input;
use Infra_Relatorio;

class PermissaoController extends AdminController {

   /**
   * Construtor padrão
   */
   public function __construct() {
       parent::__construct();
       $this->define_nomes_filtros();
   }

   /**
   * Define os nomes dos filtros da view
   */
   public function define_nomes_filtros() {
      $this->nomes_filtros = "filtro_grupo=>;";
   }

   /**
   * obtém os registros para exibir no grid
   */
   public function index() {
      $this->preparar_filtros();
      if ( $this->filtros->tem_filtro ) {
         $where = " grupo     LIKE '%{$this->filtros->filtro_grupo}%' ";
      } else {
        $where = WHERE_TODOS_REGISTROS;
      }
      $rs = Grupo::whereRaw( $where )->orderBy( $this->filtros->order,  $this->filtros->posicao )
                                       ->paginate( $this->total_registros );

      return view( 'permissoes.permissoes_grid' )->with('rs', $rs)
                                         ->with('filtros', $this->filtros );
   }

   /**
   * Método padrão para exibir o formulário(view) para:
   *     incluir,alterar,consultar,excluir e imprimir
   *
   * @param  string   $acao
   * @param  int      $id
   * @return void
   */
   public function crud( $acao, $id_grupo ) {
      switch ($acao) {
         case 'alterar':
            $readonly = '';
            $disabled = '';
            break;

        case 'imprimir':
           $this->imprimir();
        default:
          break;
      }

      $table = Grupo::find( $id_grupo );
      return view( 'permissoes.permissoes_form')->with( compact('table') )
                                            ->with( 'acao'   , $acao )
                                            ->with('readonly', $readonly )
                                            ->with('disabled', $disabled );
   }

   /**
   *  Persiste as informações no db
   *
   * @param  int      $id
   * obs: os dados são validados pelo Request
   */
   public function update() {
      $acao = Input::get('acao');
      $id_grupo = Input::get('id_grupo');		
      $inputs = Input::get();
      $permissoes = array();

      foreach ( $inputs as $key => $value) {
         if ( $value == 'on' ) {
            $key = explode( '_', $key );
            $permissoes[$key[1]] = $key[1];
         }         
      }

      DB::delete( "DELETE FROM tbpermissoes WHERE id_grupo = '{$id_grupo}' " );

      foreach ( $permissoes as $key => $value ) {
         $permissao = new Permissao;
         $permissao->id_grupo = $id_grupo;
         $permissao->id_menu  = $key;
         $permissao->save();

      }
      return redirect( 'permissao' );
   }


   /**
   *  Permissao negada
   */
   protected function show() {
      return view( 'permissoes.permissao_negada' );
   }

   /**
   *  Imprime os registros da grid
   */
   protected function imprimir() {
      $this->obter_where( $where );
      $this->obter_order( $order );
      if ( $where == '' ) {
         $where = WHERE_TODOS_REGISTROS;
      }
      $rs = DB::select( "SELECT * FROM tbgrupos WHERE {$where} ORDER BY {$order}" );
      $rel = new Infra_Relatorio();
      $rel->titulo = 'Grupos';
      $rel->AliasNbPages();
      $rel->AddPage();
      $rel->SetFont('Times', 'B', 12);
      $rel->Cell(50, 2,  utf8_decode('Grupo'    ), 0, 0, 'L');
      $rel->Line( 205, 27, 5, 27 );
      $rel->SetFont('Arial', '', 11);
      foreach ($rs as $index => $registro) {
         $rel->Ln( 7 );
         $rel->Cell(50, 8, $registro->grupo,     0, 0, 'L');
      }
      $rel->Output();
   }



}

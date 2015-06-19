<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\Grupo_Users;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;

use Input;
use Infra_Relatorio;

class GrupoController extends AdminController {

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
      
      return view( 'grupos.grupos_grid' )->with('rs', $rs)
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
         case 'incluir':
         case 'alterar':
            $readonly = '';
            $disabled = '';
            break;

        case 'consultar':
        case 'excluir':
           $readonly = 'readonly';
           $disabled = 'disabled';
           break;

        case 'imprimir':
           $this->imprimir();
        default:
          dd( ' sem ação ' );
          break;
      }

      $this->obter_usuarios_nao_selecionados( $usuarios_nao_selecionados, $acao, $id_grupo );     
      $this->obter_usuarios_selecionados( $usuarios_selecionados, $id_grupo );
      
      $table = Grupo::find( $id_grupo );
      return view( 'grupos.grupos_form')->with( compact('table') )
                                            ->with( 'acao'   , $acao )
                                            ->with('usuarios_nao_selecionados', $usuarios_nao_selecionados )
                                            ->with('usuarios_selecionados', $usuarios_selecionados )
                                            ->with('readonly', $readonly )
                                            ->with('disabled', $disabled );
   }
   
   /**
   *  Persiste as informações no db
   *
   * @param  int      $id
   * obs: os dados são validados pelo Request
   */   
   public function update( $id, Requests\GrupoRequest $request ) {
      $acao = Input::get('acao');
      switch ( $acao ) {
         case 'incluir':            
            $grupo = new Grupo;
            $grupo->grupo     = Input::get('grupo');            
            $grupo->save();
            $this->incluir_grupo_users( $grupo->id );
            break;

         case 'excluir':
            Grupo::find( $id )->delete();
            $this->excluir_grupo_users( $id );
            break;

         case 'alterar':
            $table = Grupo::findOrFail( $id );
            $table->update( $request->all() );
            $this->excluir_grupo_users( $id );
            $this->incluir_grupo_users( $id );
            break;
      }
      return redirect( 'grupo' );
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

   /**
   * Obtém os usuários Não selecionados
   */
   protected function obter_usuarios_nao_selecionados( &$resultado, $acao, $id_grupo ) {      
      $sql = ' SELECT id, name FROM users ';
      if ( $acao != 'incluir' ) {        
        $sql .= " WHERE NOT EXISTS ( SELECT id FROM tbgrupo_users 
                                     WHERE tbgrupo_users.id_user=users.id AND tbgrupo_users.id_grupo = $id_grupo ) ";
      }      
      $resultado = DB::select( $sql );      
   }  

   /**
   * Obtém os usuários Selecionados
   */
   protected function obter_usuarios_selecionados( &$resultado, $id_grupo ) {
      $resultado = DB::select(' SELECT users.id, users.name 
                                FROM tbgrupo_users JOIN users ON ( tbgrupo_users.id_user = users.id )
                                WHERE id_grupo = :id_grupo', [ 'id_grupo' => $id_grupo ] );
   }  

   /**
   *  Inclui os grupos
   * @param     int      $id_grupo
   */   
   protected function incluir_grupo_users( $id_grupo ) {
      $ids = explode( ';', Input::get('ids_selecionados') );
      foreach ( $ids as $key => $id_user ) {
         if( $id_user ) {
            $grupo_users = new Grupo_Users();
            $grupo_users->id_grupo = $id_grupo;
            $grupo_users->id_user = $id_user;
            $grupo_users->save();
         }
      }       
   }
            
   /**
   *  Exlui todos os registros do grupo
   * @param     int      $id_grupo
   */   
   protected function excluir_grupo_users( $id_grupo ) {
      $sql  = " DELETE FROM tbgrupo_users WHERE id_grupo = '{$id_grupo}' ";
      DB::delete( $sql );
   }

}

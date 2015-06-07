<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;

use Input;
use Infra_Relatorio;


class ProdutoController extends AdminController {

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
      $this->nomes_filtros = "filtro_codigo=>;".
                             "filtro_descricao=>;";
   }

   /**
   * obtém os registros para exibir no grid
   */
   public function index() {
      $this->preparar_filtros();
      if ( $this->filtros->tem_filtro ) {
         $where = " codigo    LIKE '%{$this->filtros->filtro_codigo}%' AND
                    descricao LIKE '%{$this->filtros->filtro_descricao}%'
                ";         
      } else {
        $where = WHERE_TODOS_REGISTROS;
      }
      $rs = Produto::whereRaw( $where )->orderBy( $this->filtros->order,  $this->filtros->posicao )
                                       ->paginate( $this->total_registros );
      return view( 'produtos.produtos_grid' )->with('rs', $rs)                                             
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
   public function crud( $acao, $id ) {      
      switch ($acao) {
         case 'incluir':
         case 'alterar':
            $readonly = '';
            break;
        case 'consultar':
        case 'excluir':
           $readonly = 'readonly';
           break;
        case 'imprimir':
           $this->imprimir();
        default:
          dd( ' sem ação ' );
          break;
      }
      $table = Produto::find( $id );
      return view( 'produtos.produtos_form')->with( compact('table') )
                                            ->with( 'acao'   , $acao )
                                            ->with('readonly', $readonly );
   }
   
   /**
   *  Persiste as informações no db
   *
   * @param  int      $id
   * obs: os dados são validados pelo Request
   */   
   public function update( $id, Requests\ProdutoRequest $request ) {
      $acao = Input::get('acao');      
      switch ( $acao ) {
         case 'incluir':
            Produto::create( $request->all() );
            break;

         case 'excluir':
            Produto::find( $id )->delete();
            break;

         case 'alterar':
            $table = Produto::findOrFail( $id );
            $table->update( $request->all() );
            break;
      }
      return redirect( 'produto' );
   }
   
   /**
   *  Imprime os registros da grid
   */   
   public function imprimir() {  
      $this->obter_where( $where );
      $this->obter_order( $order );
      if ( $where == '' ) {
         $where = WHERE_TODOS_REGISTROS;
      }       
      $rs = DB::select( "SELECT * FROM tbprodutos WHERE {$where} ORDER BY {$order}" );
      //dd($registro);
      $rel = new Infra_Relatorio();
      $rel->titulo = 'Produtos';
      $rel->AliasNbPages();
      $rel->AddPage();
      $rel->SetFont('Times', 'B', 12);
      $rel->Cell(20, 2,  utf8_decode('Código'    ), 0, 0, 'L');
      $rel->Cell(80, 2,  utf8_decode('Descrição' ), 0, 0, 'L');
      $rel->Cell(38, 2,  utf8_decode('Quantidade'), 0, 0, 'L');
      $rel->Cell(20, 2,  utf8_decode('Preço'     ), 0, 0, 'L');
      $rel->Line( 205, 27, 5, 27 );
      $rel->SetFont('Arial', '', 11);            
      foreach ($rs as $index => $registro) {
         $rel->Ln( 7 );
         $rel->Cell(20, 8, $registro->codigo,     0, 0, 'L');
         $rel->Cell(80, 8, utf8_decode($registro->descricao),  0, 0, 'L');
         $rel->Cell(30, 7, $registro->quantidade, 0, 0, 'L');
         $rel->Cell(20, 6, $registro->preco,      0, 0, 'R');
      }
      $rel->Output();
   }

}

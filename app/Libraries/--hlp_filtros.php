<?php

namespace App\Bibliotecas;

use DB;

/*
* Classe helper para auxiliar nos Filtros das tabelas do BD
*
* @author moinunes
*/

class hlp_filtros extends \Eloquent {   
   /**
   *  Nome da tabela  
   */
   public $nome_tabela;
   
   /**
   * Obtém a clausula where de acordo com os filtros
   * 
   * param array     inputs com o name iniciado com: filtro_
   * 
   * @return string
   */
   public function obter_where( &$where, $filtros ) {            
      $array_filtros = array();
      $where         = '';
      
      //.. obtem os nomes das colunas
      $hlp_tabela = new \App\Bibliotecas\hlp_tabela(); 
      $hlp_tabela->table = $this->nome_tabela;
      $colunas = $hlp_tabela->obter_colunas();
      
      //.. monta o $array_filtros ( campo, tipo e valor ) 
      foreach( $filtros as $campo => $valor ) {
         if ( substr( $campo,0, 6 ) == 'filtro' ) {
            $nome_campo = str_replace( 'filtro_', '', $campo );
            foreach( $colunas as $index => $item ) {
               if ( $item['Field'] == $nome_campo ) {       
                 $array_filtros[] = array( 'nome_campo'=>$nome_campo, 'tipo'=> $item['Type'], 'valor' => $valor );
               }
            }            
         }
      }
      
      //.. monta a clausula WHERE com o $array_filtros 
      foreach( $array_filtros as $index => $item ) { 
         $nome_campo = $item['nome_campo'];
         $valor      = $item['valor'];
         $tipo       = $item['tipo'];
         if( $valor != '' ) {
            if ( strstr( $tipo, 'char' ) != '' ) {
               $where .= " {$nome_campo} LIKE '%{$valor}%' AND";
            } else {
               $where .= " {$nome_campo} = '{$valor}' AND";
            }            
         }         
      }
      $where = substr( $where, 0, strlen($where)-3 );
   }
   
   /**
   * Guarda os filtros
   *     
   * @param  array    $filtros 
   * @return array
   * 
   */
   public function guardar_filtros( &$resultado, $filtros ) {
      $resultado = new \stdClass();
      
      if ( count( $filtros ) > 1 ) {          
         foreach( $filtros as $campo => $valor ) {
            if ( substr( $campo,0, 6 ) == 'filtro' ) {
               $nome_campo = str_replace( 'filtro_', '', $campo );
               $resultado->$nome_campo = $valor;
            }
         }         
      } else {
         $hlp_tabela = new \App\Bibliotecas\Hlp_Tabela(); 
         $hlp_tabela->table = $this->nome_tabela;
         $colunas = $hlp_tabela->obter_colunas();        
         
         print '<pre>'; var_dump( $colunas); die( ' oi ' );
         
         foreach( $colunas as $index => $item ) {
            $nome_campo = explode( $item->Field, ' ' );
            $nome_campo = $item['Field'];
            $resultado->$nome_campo = '';   
         }         
      }
      
   }
   
}
<?php

namespace App\Bibliotecas;
use DB;

/*
* Classe helper para auxiliar com informações das tabelas do BD
*
* @author moinunes
*/

class hlp_tabela extends \Eloquent {
   
   /**
   * Obtem as colunas da tabela 
   *   -> nome, tipo e tamanho
   * @return array
   */
   public function obter_schema_tabela(  $nome_tabela) {
      switch (DB::connection()->getConfig('driver')) {
         case 'pgsql':
            $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '".$nome_tabela."'";
            $column_name = 'column_name';
            $reverse = true;
            break;

         case 'mysql':
            $query = 'SHOW COLUMNS FROM '.$nome_tabela;
            $column_name = 'Field';
            $reverse = false;           
            break;
      }
      $columns = array();
      foreach(DB::select($query) as $column ) {
         $columns[] = $column;
      }
      if( $reverse ) {
         $columns = array_reverse($columns);
      }
      return $columns;
   }
   
}

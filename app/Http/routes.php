<?php

/**************************************************************************
*
* Define as rotas da aplicação
*
***************************************************************************/

// login
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// home
Route::get( '/'  , 'HomeController@index' );
Route::get( 'home', 'HomeController@index' );

//.. produto
Route::resource('produto'       , 'ProdutoController'          );
//Route::post('produto'           , 'ProdutoController@index'    );
Route::any('produto', 'ProdutoController@index');
Route::get('produto/{acao}/{id}', 'ProdutoController@crud'     );

//.. unidadesmedida
//Route::resource('unidadesmedida'       , 'UnidadesMedidaController'          );
//Route::post('unidadesmedida'           , 'UnidadesMedidaController@index'    );
//Route::get('unidadesmedida/{acao}/{id}', 'UnidadesMedidaController@crud'     );


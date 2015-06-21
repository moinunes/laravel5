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
Route::get( '/',    'HomeController@index' );
Route::get( 'home', 'HomeController@index' );

//.. produto
Route::resource('produto',        'ProdutoController'       );
Route::any('produto',             'ProdutoController@index' );
Route::get('produto/{acao}/{id}', 'ProdutoController@crud'  );

//.. unidadesmedida
//Route::resource('unidadesmedida',        'UnidadesMedidaController'       );
//Route::post('unidadesmedida',            'UnidadesMedidaController@index' );
//Route::get('unidadesmedida/{acao}/{id}', 'UnidadesMedidaController@crud'  );

//.. user
Route::resource('user',        'UserController'       );
Route::any('user',             'UserController@index' );
Route::get('user/{acao}/{id}', 'UserController@crud'  );

//.. grupo
Route::resource('grupo',        'GrupoController'       );
Route::any('grupo',             'GrupoController@index' );
Route::get('grupo/{acao}/{id}', 'GrupoController@crud'  );

//.. permissao
Route::resource('permissao',        'PermissaoController'       );
Route::any('permissao',             'PermissaoController@index' );
Route::get('permissao/{acao}/{id}', 'PermissaoController@crud'  );


//.. tools
Route::resource( 'tools', 'ToolsController'       );

<?php namespace App\Http\Middleware;

use Closure;
use App\Libraries\Infra\Infra_Permissao;
use Auth;
use Request;

class PermissaoMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)	{
		$rota = Request::segment(1);      
      if ( $rota != null && $rota != 'auth' && Auth::user() ) {      	
         $permissao = new Infra_Permissao();
			if ( !$permissao->tem_permissao() ) {
				//die( 'NÂO tem permssao - redirecionar para uma view sem permissao');
				return redirect( 'permissao/negada' );
         } 
      }
		return $next($request);
	}

}

<?php namespace App\Http\Middleware;

use Closure;
use App\Libraries\Infra\Infra_Permissao;
use Auth;
use Request;




// em desuso




class PermissaoMiddlewarexxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle( $request, Closure $next )	{
		$rota = Request::segment(1);   
      if ( $rota == 'auth' && Auth::guest() ) { 
          return redirect( '/auth/login' );
      }
print time(); dd('rrr');
//dd($rota);

      if ( $request->is('auth')  ) {
         dd('ddd');
          return redirect( '/auth/login' );
       }

         

      if ( !$request->is('/auth/login') && Auth::guest() ) {

     //    dd('oi');
         
         return redirect( '/auth/login' );
         
      }

      print $rota;   

      if ( ( $rota == null    || 
             $rota == 'auth' || 
             $rota == 'home' || 
             $request->is('permissao/negada') 
           )  && ( Auth::guest() )
         ) {
         return $next($request);
      }
      
      //dd( $request->is('Auth/logout') );

      $url = Request::url();
      print_r($url);
      //dd();   
      if ( !Infra_Permissao::tem_permissao() ) {
			//die( 'NÂO tem permssao - redirecionar para uma view sem permissao');
         print time();
         //dd();
		   return redirect( 'permissao/negada' );
      } 
      
		return $next($request);
	}

}

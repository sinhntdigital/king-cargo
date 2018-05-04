<?php
	
	namespace App\Http\Middleware;
	
	use Closure;
	
	/**
	 * Class UserCheckMiddleware
	 *
	 * @package App\Http\Middleware
	 */
	class AdminCheckMiddleware {
		
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Closure                 $next
		 *
		 * @return mixed
		 */
		public function handle($request, Closure $next) {
//			if(empty(\Session::get('approved')))
//				return redirect()->route('gmCheckBrowser');
			
			if(!\Auth::check())
				return redirect()->route('gmGetLogin');
			
			if((int)\Auth::user()->role !== 9)
				abort(403);
			
			return $next($request);
		}
		
	}

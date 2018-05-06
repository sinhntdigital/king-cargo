<?php

namespace App\Http\Middleware;

use Closure;

class GetlocaleMiddleware {

    /**
     * Handle an incoming request.
     * @param          $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle ($request, Closure $next) {
        $value = $request->cookie('app_locale');
        \App::setLocale($value);
        return $next($request);
    }
}

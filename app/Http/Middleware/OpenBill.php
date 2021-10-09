<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class OpenBill
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $credential = Session::get('authenticate');
        if($credential -> emp_role != 1) {
          return redirect() -> back();
        }

        return $next($request);
    }
}

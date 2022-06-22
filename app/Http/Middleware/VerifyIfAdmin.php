<?php

namespace App\Http\Middleware;
use Closure;
use Session;

class VerifyIfAdmin
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
        $adminUser = Session::get('userid');

        if (!$adminUser == '1') {
            
            return redirect()->route('homepage');
           
        }
        
        return $next($request);
    }
}

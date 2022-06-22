<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class VerifyIfCandidate
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
        $candidateUser = Session::get('userEmail');
        
        if ($candidateUser == '') {
            // echo 'not varify candidate: '.$candidateUser;
            // exit;
            return redirect()->route('signin.index');
            
        }else{
            return $next($request);
        }
        
    }
}

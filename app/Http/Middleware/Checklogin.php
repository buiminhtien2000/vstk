<?php

namespace App\Http\Middleware;
session_start();
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Checklogin extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request,$next)
    {
    //    if(isset($_COOKIE['vstk-login'])){
    //     return $next($request);
    //    }else{
    //     return redirect('login');
    //    }
        
    }
}

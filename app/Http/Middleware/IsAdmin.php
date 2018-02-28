<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Support\Enum\RoleTypes;
use ApiResponse;
use Lang;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
    
        
        $user = JWTAuth::parseToken()->toUser();
        
        if (in_array(RoleTypes::ADMIN, $user->roles->toArray())) {
            return ApiResponse::Unauthorized(Lang::get('auth.insufficient_permissions'), 401);
        }        

        return $next($request);                
    }
}

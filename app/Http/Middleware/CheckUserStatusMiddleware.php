<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Support\Enum\UserStatuses;
use ApiResponse;
use Lang;

/**
 * Adapted JWTMiddleware to work with ApiResponse
 */
class CheckUserStatusMiddleware
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
        $user = JWTAuth::parseToken()->toUser();
        if ($user->status == UserStatuses::UNCONFIRMED) {
            return ApiResponse::Unauthorized( Lang::get('dinkoapi.auth.confirm_email'), 401);
        }

        if ($user->status == UserStatuses::BANNED) {
            return ApiResponse::Forbidden( Lang::get('dinkoapi.auth.banned'), 403);
        }
        
        if($user->passwordReset){
            return ApiResponse::Unauthorized( Lang::get('dinkoapi.passwords.reset_password_requested'), 401);
        }

        return $next($request);
    }
}

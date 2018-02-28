<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
        'dinkoapi.auth' => \Dinkara\DinkoApi\Http\Middleware\DinkoApiAuthMiddleware::class,
        'is.admin' => \App\Http\Middleware\IsAdmin::class,    
        'user.check.status' => \App\Http\Middleware\CheckUserStatusMiddleware::class,
        'exists.category' => \App\Http\Middleware\CategoryExists::class,    
        'exists.image' => \App\Http\Middleware\ImageExists::class,    
        'exists.loading' => \App\Http\Middleware\LoadingExists::class,    
        'exists.order' => \App\Http\Middleware\OrderExists::class,    
        'exists.profile' => \App\Http\Middleware\ProfileExists::class,    
        'exists.project' => \App\Http\Middleware\ProjectExists::class,    
        'exists.question' => \App\Http\Middleware\QuestionExists::class,    
        'exists.review' => \App\Http\Middleware\ReviewExists::class,    
        'exists.role' => \App\Http\Middleware\RoleExists::class,    
        'exists.socialnetwork' => \App\Http\Middleware\SocialNetworkExists::class,    
        'exists.truck' => \App\Http\Middleware\TruckExists::class,    
        'exists.user' => \App\Http\Middleware\UserExists::class,    
        'owns.loading' => \App\Http\Middleware\LoadingOwner::class,    
        'owns.profile' => \App\Http\Middleware\ProfileOwner::class,    
        'owns.review' => \App\Http\Middleware\ReviewOwner::class,    
    
    ];
}

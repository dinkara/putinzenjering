<?php

namespace App\Http\Middleware;

use Closure;
use Dinkara\DinkoApi\Http\Middleware\DinkoApiExistsMiddleware;
use App\Repositories\SocialNetwork\ISocialNetworkRepo;

class SocialNetworkExists extends DinkoApiExistsMiddleware
{ 
       
    
    /**
     * Create a new SocialNetwork Middleware instance.
     *
     * @return void
     */
    public function __construct(ISocialNetworkRepo $repo) {
        $this->repo = $repo;        
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $key = 'social_network_id', $isForeign = false)
    {                        
        $this->id = $request->id;
        
        if($isForeign){            
	    $this->id = $request->get("$key");
            
            if(!$this->id){
                $this->id = eval('return $request->'.$key.';');
            }
        }
        
        if($this->id === null){
            return $next($request);
        }
        
	return parent::handle($request, $next);			
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Dinkara\DinkoApi\Http\Middleware\DinkoApiExistsMiddleware;
use App\Repositories\Review\IReviewRepo;

class ReviewExists extends DinkoApiExistsMiddleware
{ 
       
    
    /**
     * Create a new Review Middleware instance.
     *
     * @return void
     */
    public function __construct(IReviewRepo $repo) {
        $this->repo = $repo;        
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $key = 'review_id', $isForeign = false)
    {                        
        $this->id = $request->id;
        
        if($isForeign){            
	    $this->id = $request->get("$key");
            
            if(!$this->id){
                $this->id = eval('return $request->'.$key.';');
            }
        }
        
        if(!$this->id){
            return $next($request);
        }
        
	return parent::handle($request, $next);			
    }
}

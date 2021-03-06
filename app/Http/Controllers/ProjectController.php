<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Repositories\Project\IProjectRepo;
use App\Transformers\ProjectTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use App\Transformers\OrderTransformer;
use App\Transformers\UserTransformer;


/**
 * @resource Project
 */
class ProjectController extends ResourceController
{

    
    
    public function __construct(IProjectRepo $repo, ProjectTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
    
    
    
    }        
    
    /**
     * Get all Order for Project with given $id
     *
     * Orders from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allOrders(Request $request, $id)
    {	   
        try{
            return ApiResponse::Collection($this->repo->find($id)->getModel()->orders($request->q, $request->orderBy)->get(), new OrderTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Order for Project with given $id 
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedOrders(Request $request, $id)
    {   
        try{    
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->orders($request->q, $request->orderBy)->paginate($pagination), new OrderTransformer); 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->orders($request->q, $request->orderBy)->paginate(), new OrderTransformer); 
            }   
            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    /**
     * Get all User for Project with given $id
     *
     * Users from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allUsers(Request $request, $id)
    {	   
        try{
            return ApiResponse::Collection($this->repo->find($id)->getModel()->users($request->q, $request->orderBy)->get(), new UserTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated User for Project with given $id 
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedUsers(Request $request, $id)
    {   
        try{    
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->users($request->q, $request->orderBy)->paginate($pagination), new UserTransformer); 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->users($request->q, $request->orderBy)->paginate(), new UserTransformer); 
            }   
            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }



}
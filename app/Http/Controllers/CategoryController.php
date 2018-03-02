<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\Category\ICategoryRepo;
use App\Transformers\CategoryTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use App\Transformers\OrderTransformer;


/**
 * @resource Category
 */
class CategoryController extends ResourceController
{

    
    
    public function __construct(ICategoryRepo $repo, CategoryTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
    
    
    
    }
        
    /**
     * Get all Order for Category with given $id
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
     * Paginated Order for Category with given $id 
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



}
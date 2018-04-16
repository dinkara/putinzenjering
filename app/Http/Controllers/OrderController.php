<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Repositories\Order\IOrderRepo;
use App\Transformers\OrderTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use App\Transformers\ReviewTransformer;
use App\Transformers\LoadingTransformer;
use App\Http\Requests\SearchOrderRequest;

/**
 * @resource Order
 */
class OrderController extends ResourceController
{

    
    
    public function __construct(IOrderRepo $repo, OrderTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
        $this->middleware('exists.category:category_id,true', ['only' => ['store']]);

        $this->middleware('exists.project:project_id,true', ['only' => ['store']]);

    
    
    
    }      
    
    /**
     * Get all Review for Order with given $id
     *
     * Reviews from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allReviews(Request $request, $id)
    {	   
        try{
            return ApiResponse::Collection($this->repo->find($id)->getModel()->reviews($request->q, $request->orderBy)->get(), new ReviewTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Review for Order with given $id 
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedReviews(Request $request, $id)
    {   
        try{    
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->reviews($request->q, $request->orderBy)->paginate($pagination), new ReviewTransformer); 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->reviews($request->q, $request->orderBy)->paginate(), new ReviewTransformer); 
            }   
            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    /**
     * Get all Loading for Order with given $id
     *
     * Loadings from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allLoadings(Request $request, $id)
    {	   
        try{
            return ApiResponse::Collection($this->repo->find($id)->getModel()->loadings($request->q, $request->orderBy)->get(), new LoadingTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Loading for Order with given $id 
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedLoadings(Request $request, $id)
    {   
        try{    
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->loadings($request->q, $request->orderBy)->paginate($pagination), new LoadingTransformer); 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->loadings($request->q, $request->orderBy)->paginate(), new LoadingTransformer); 
            }   
            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }

    public function search(SearchOrderRequest $request) {
        try{
            //dd($this->repo->searchByRelation($request->project_id, $request->category_id));
            return ApiResponse::Collection($this->repo->searchByRelation($request->project_id, $request->category_id), new $this->transformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }        
    }


}
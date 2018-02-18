<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLoadingRequest;
use App\Http\Requests\UpdateLoadingRequest;
use App\Repositories\Loading\ILoadingRepo;
use App\Transformers\LoadingTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use App\Transformers\ImageTransformer;


/**
 * @resource Loading
 */
class LoadingController extends ResourceController
{

    
    
    public function __construct(ILoadingRepo $repo, LoadingTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
        $this->middleware('exists.review:review_id,true', ['only' => ['store']]);

        $this->middleware('exists.truck:truck_id,true', ['only' => ['store']]);

        $this->middleware('exists.order:order_id,true', ['only' => ['store']]);

        $this->middleware('owns.loading', ['only' => ['update', 'destroy']]);

    
    
    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreLoadingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoadingRequest $request)
    {       
        $data = $request->only($this->repo->getModel()->getFillable());

	    $data["user_id"] = JWTAuth::parseToken()->toUser()->id;   
    
        return $this->storeItem($data);
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateLoadingRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoadingRequest $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable());        
        $item = $this->repo->find($id);

	    $data["user_id"] = JWTAuth::parseToken()->toUser()->id;   
    
        return $this->updateItem($data, $id);
    }

        /**
     * Remove item
     * 
     * Remove the specified item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($item = $this->repo->find($id)){
                
                $item->delete($id);
                return ApiResponse::ItemDeleted($this->repo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
        
        return ApiResponse::ItemNotFound($this->repo->getModel());       
    }
    
    /**
     * Get all Image for Loading with given $id
     *
     * Images from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allImages(Request $request, $id)
    {	   
        try{
            return ApiResponse::Collection($this->repo->find($id)->getModel()->images($request->q, $request->orderBy)->get(), new ImageTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Image for Loading with given $id 
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedImages(Request $request, $id)
    {   
        try{    
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->images($request->q, $request->orderBy)->paginate($pagination), new ImageTransformer); 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->images($request->q, $request->orderBy)->paginate(), new ImageTransformer); 
            }   
            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }



}
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\SearchOrderRequest;
use App\Repositories\Order\IOrderRepo;
use App\Repositories\Project\IProjectRepo;
use App\Transformers\OrderTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use App\Transformers\ReviewTransformer;
use App\Transformers\LoadingTransformer;
use PDF;

/**
 * @resource Admin\Order
 */
class OrderController extends ResourceController
{

    protected $projectRepo;
    
    
    public function __construct(IOrderRepo $repo, IProjectRepo $projectRepo, OrderTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
        $this->projectRepo = $projectRepo;
        $this->middleware('exists.category:category_id,true', ['only' => ['store']]);

        $this->middleware('exists.project:project_id,true', ['only' => ['store']]);

    
    
    
    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {       
        $data = $request->only($this->repo->getModel()->getFillable());
	
        $result = $this->storeItem($data);
        
        $this->projectRepo->find($data["project_id"])->checkToUpdateStatus();
                
        return $result;
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateOrderRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable());        
        //$item = $this->repo->find($id);

        try {
            if( $item = $this->repo->find($id)){                
                return ApiResponse::ItemUpdated($item->update($data)->checkToUpdateStatus()->getModel(), new $this->transformer, class_basename($this->repo->getModel()));
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
        return ApiResponse::ItemNotFound($this->repo->getModel());        	
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
                
                $this->projectRepo->find($this->repo->getModel()->project_id)->checkToUpdateStatus();
                
                return ApiResponse::ItemDeleted($this->repo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
        
        return ApiResponse::ItemNotFound($this->repo->getModel());       
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

    public function pdf($id) {
        $reviews = $this->repo->find($id)->getModel()->reviews;
                
        $pdf = PDF::loadView('pdf.multiple', ['reviews' => $reviews]);
        
        return $pdf->stream('reviews.pdf');
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
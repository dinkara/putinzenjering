<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Repositories\Question\IQuestionRepo;
use App\Transformers\QuestionTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use App\Transformers\ReviewTransformer;


/**
 * @resource Admin\Question
 */
class QuestionController extends ResourceController
{

    
    
    public function __construct(IQuestionRepo $repo, QuestionTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
    
    
    
    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {       
        $data = $request->only($this->repo->getModel()->getFillable());

	
        return $this->storeItem($data);
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateQuestionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable());        
        $item = $this->repo->find($id);

	
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
     * Get all Review for Question with given $id
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
     * Paginated Review for Question with given $id 
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



}
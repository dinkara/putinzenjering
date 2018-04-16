<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Requests\SearchReviewRequest;
use App\Repositories\Review\IReviewRepo;
use App\Repositories\Order\IOrderRepo;
use App\Transformers\ReviewTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use Lang;
use ApiResponse;
use App\Http\Requests\ReviewAttachQuestionRequest;
use App\Repositories\Question\IQuestionRepo;
use App\Transformers\QuestionTransformer;
use App\Transformers\ImageTransformer;
use PDF;

/**
 * @resource Admin\Review
 */
class ReviewController extends ResourceController
{

    /**
     * @var IQuestionRepo 
     */
    private $questionRepo;
        
    /**
     * @var IOrderRepo 
     */
    private $orderRepo;
      
    public function __construct(IReviewRepo $repo, ReviewTransformer $transformer, IQuestionRepo $questionRepo, IOrderRepo $orderRepo) {
        parent::__construct($repo, $transformer);
	
        $this->middleware('exists.order:order_id,true', ['only' => ['store']]);

        $this->middleware('owns.review', ['only' => ['update', 'destroy']]);

        $this->middleware('exists.review', ['only' => ['attachQuestion', 'detachQuestion']]);
    
        $this->middleware('exists.question:question_id,true', ['only' => ['attachQuestion', 'detachQuestion']]);

        $this->middleware('owns.review', ['only' => ['attachQuestion', 'detachQuestion']]);

    	$this->questionRepo = $questionRepo;
        
        $this->orderRepo = $orderRepo;

    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewRequest $request)
    {       
        $data = $request->only($this->repo->getModel()->getFillable());

        $data["user_id"] = JWTAuth::parseToken()->toUser()->id;
        $order_id = $request->get('order_id');
        $order = $this->orderRepo->find($order_id)->getModel();
        $count = count($order->reviews);
        $data['position'] = $count + 1;
        if($count < $order->quantity){
            try {
                $result = $this->repo->create($data)->getModel();
                $result->position = $count + 1;
                $result->save();
                return ApiResponse::ItemCreated($result, $this->transformer);
            } catch (QueryException $e) {
                return ApiResponse::InternalError($e->getMessage());
            }
        }
        
        return ApiResponse::Forbidden(Lang::get("messages.review.max"));
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateReviewRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewRequest $request, $id)
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
     * Get all Question for Review with given $id
     *
     * Questions from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allQuestions(Request $request, $id)
    {	   
        try{
            return ApiResponse::Collection($this->repo->find($id)->getModel()->questions($request->q, $request->orderBy)->get(), new QuestionTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Question for Review with given $id 
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedQuestions(Request $request, $id)
    {   
        try{    
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->questions($request->q, $request->orderBy)->paginate($pagination), new QuestionTransformer); 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($id)->getModel()->questions($request->q, $request->orderBy)->paginate(), new QuestionTransformer); 
            }   
            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    /**
     * Get all Image for Review with given $id
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
     * Paginated Image for Review with given $id 
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

    /**
     * Attach Question
     *
     * Attach the Question to existing resource.
     *
     * @param  App\Http\Requests\ReviewAttachQuestionRequest  $request
     * @param  int  $id
     * @param  int  $question_id
     * @return \Illuminate\Http\Response
     */
    public function attachQuestion(ReviewAttachQuestionRequest $request, $id, $question_id)
    {
            $data = $request->only(array_keys($request->rules()));
	    	
	    $model = $this->questionRepo->find($question_id)->getModel();

            return ApiResponse::ItemAttached($this->repo->find($id)->attachQuestion($model, $data)->getModel(), $this->transformer);
    }

    
    /**
     * Detach Question
     *
     * Detach the Question from existing resource.
     *
     * @param  App\Http\Requests\ReviewAttachQuestionRequest  $request
     * @param  int  $id
     * @param  int  $question_id
     * @return \Illuminate\Http\Response
     */
    public function detachQuestion($id, $question_id)
    {	    	
	$model = $this->questionRepo->find($question_id)->getModel();
        return ApiResponse::ItemDetached($this->repo->find($id)->detachQuestion($model)->getModel());
    }

    public function pdf($id) {
        
        $review = $this->repo->find($id)->getModel();
        $pdf = PDF::loadView('pdf.review', ['review' => $review]);
        
        //return view('pdf.review', ['review' => $review]);
        return $pdf->stream('review.pdf');
    }
    
    public function pdfAll(SearchReviewRequest $request) {                
        
        $reviews = $this->repo->searchByRelation($request->q, $request->project_id, $request->order_id, $request->category_id);

        $pdf = PDF::loadView('pdf.multiple', ['reviews' => $reviews]);
        
        return $pdf->stream('all.pdf');                  
        

    }
    
    public function search(SearchReviewRequest $request) {
        try{
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->searchAndPaginateByRelation($request->q, $request->project_id, $request->order_id, $request->category_id, $pagination), new $this->transformer);
            }
            else{
                return ApiResponse::Pagination($this->repo->searchAndPaginateByRelation($request->q, $request->project_id, $request->order_id, $request->category_id), new $this->transformer);
            }
            //dd($this->repo->searchByRelation($request->project_id, $request->category_id));            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }        
    }
}
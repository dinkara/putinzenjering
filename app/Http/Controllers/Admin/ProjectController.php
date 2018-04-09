<?php

namespace App\Http\Controllers\Admin;

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
use App\Http\Requests\UserAttachProjectRequest;
use App\Repositories\User\IUserRepo;

/**
 * @resource Admin\Project
 */
class ProjectController extends ResourceController
{

    /**
     * @var IUserRepo 
     */
    private $userRepo;
    
    public function __construct(IProjectRepo $repo, ProjectTransformer $transformer, IUserRepo $userRepo) {
        parent::__construct($repo, $transformer);
	
        $this->userRepo = $userRepo;
    
    
    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {       
        $data = $request->only($this->repo->getModel()->getFillable());

	
        return $this->storeItem($data);
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateProjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable()); 
        
        //$item = $this->repo->find($id);

	
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


     /**
     * Attach User
     *
     * Attach the User to existing Project.
     *
     * @param  App\Http\Requests\UserAttachProjectRequest  $request
     * @param  int  $id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function attachUser(UserAttachProjectRequest $request, $id, $user_id)
    {
            $data = $request->only(array_keys($request->rules()));

            //$project = $this->repo->find($id)->getModel();
	    	
	    $model = $this->userRepo->find($user_id)->getModel();

            return ApiResponse::ItemAttached($this->repo->find($id)->attachUser($model, $data)->getModel(), $this->transformer);
    }

    /**
     * Detach User
     *
     * Detach the specified resource from existing resource.
     *
     * @param  int  $id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function detachUser($id, $user_id)
    {	    	
	$model = $this->userRepo->find($user_id)->getModel();
        //$user = $this->repo->find($id)->getModel();
        return ApiResponse::ItemDetached($this->repo->find($id)->detachUser($model)->getModel());
    }
}
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\User\IUserRepo;
use App\Repositories\Profile\IProfileRepo;
use App\Transformers\UserTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Database\QueryException;
use Storage;
use ApiResponse;
use Lang;
use App\Http\Requests\UserAttachRoleRequest;
use App\Repositories\Role\IRoleRepo;
use App\Http\Requests\UserAttachSocialNetworkRequest;
use App\Http\Requests\StoreUserRequest;
use App\Repositories\SocialNetwork\ISocialNetworkRepo;
use App\Http\Requests\UserAttachProjectRequest;
use App\Repositories\Project\IProjectRepo;
use App\Transformers\RoleTransformer;
use App\Transformers\SocialNetworkTransformer;
use App\Transformers\ProjectTransformer;
use App\Transformers\ReviewTransformer;
use App\Transformers\LoadingTransformer;
use App\Support\Enum\RoleTypes;

/**
 * @resource User
 */
class UserController extends ResourceController
{

    protected $profileRepo;
    /**
     * @var IRoleRepo 
     */
    private $roleRepo;
        /**
     * @var ISocialNetworkRepo 
     */
    private $socialNetworkRepo;
        /**
     * @var IProjectRepo 
     */
    private $projectRepo;
        
    
    public function __construct(IProfileRepo $profileRepo, IUserRepo $repo, UserTransformer $transformer, IRoleRepo $roleRepo, ISocialNetworkRepo $socialNetworkRepo, IProjectRepo $projectRepo) {
        parent::__construct($repo, $transformer);
	$this->profileRepo = $profileRepo;
        $this->middleware('exists.role:role_id,true', ['only' => ['attachRole', 'detachRole']]);

        $this->middleware('exists.socialnetwork:social_network_id,true', ['only' => ['attachSocialNetwork', 'detachSocialNetwork']]);

        $this->middleware('exists.project:project_id,true', ['only' => ['attachProject', 'detachProject']]);

    
    	$this->roleRepo = $roleRepo;
	$this->socialNetworkRepo = $socialNetworkRepo;
	$this->projectRepo = $projectRepo;

    }   
    
    /**
     * Store
     * 
     * Create new user
     * @param StoreUserRequest $request
     * @return type
     */
    public function store(StoreUserRequest $request) {

        try{
            $requestKeys = array_keys($request->rules());
            $userData = $request->only(array_intersect($requestKeys, $this->repo->getModel()->getFillable()));
            $profileData = $request->only(array_intersect($requestKeys, $this->profileRepo->getModel()->getFillable()));
            $this->repo->register($userData, false)->attachRole($this->roleRepo->findByName($request->role)->getModel());
            $profileData["user_id"] = $this->repo->getModel()->id;

            $this->profileRepo->create($profileData);

            return ApiResponse::ItemCreated($this->repo->getModel(), $this->transformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    
    
    /**
     * Show
     * 
     * Display user with given id.
     *     
     * @param  int  $id     
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {            
            
            if($item = $this->repo->find($id)->getModel()){

                return ApiResponse::Item($item->getModel(), new $this->transformer);
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }    
        
        return ApiResponse::ItemNotFound($this->repo->getModel());
        
    }
    
    /**
     * Update profile
     * 
     * Update profile info.
     *
     * @param  App\Http\Requests\UpdateProfileRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, $id)
    {       
            try {
                $user = $this->repo->find($id)->getModel();
                $data = $request->only(array_keys($request->rules()));
                
                if( $item = $this->profileRepo->find($user->profile->id)->update($data)){
                    //refresh user after update
                    return ApiResponse::ItemUpdated($this->repo->find($user->id)->getModel(), new $this->transformer, class_basename($this->repo->getModel()));
                }
            } catch (QueryException $e) {
                return ApiResponse::InternalError($e->getMessage());
            }
    }
    
    /**
     * Get all Role
     *
     * Roles from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allRoles(Request $request, $id)
    {	   
        try{
            $user = $this->repo->find($id)->getModel();
            return ApiResponse::Collection($this->repo->find($user->id)->getModel()->roles($request->q, $request->orderBy)->get(), new RoleTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Role
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedRoles(Request $request, $id)
    {   
        try{
            $user = $this->repo->find($id)->getModel();
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->roles($request->q, $request->orderBy)->paginate($pagination), new RoleTransformer);                 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->roles($request->q, $request->orderBy)->paginate(), new RoleTransformer); 
            }   

            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    /**
     * Get all SocialNetwork
     *
     * SocialNetworks from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allSocialNetworks(Request $request, $id)
    {	   
        try{
            $user = $this->repo->find($id)->getModel();
            return ApiResponse::Collection($this->repo->find($user->id)->getModel()->socialNetworks($request->q, $request->orderBy)->get(), new SocialNetworkTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated SocialNetwork
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedSocialNetworks(Request $request, $id)
    {   
        try{
            $user = $this->repo->find($id)->getModel(); 
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->socialNetworks($request->q, $request->orderBy)->paginate($pagination), new SocialNetworkTransformer);                 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->socialNetworks($request->q, $request->orderBy)->paginate(), new SocialNetworkTransformer); 
            }   

            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    /**
     * Get all Project
     *
     * Projects from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function allProjects(Request $request, $id)
    {	   
        try{
            $user = $this->repo->find($id)->getModel();
            return ApiResponse::Collection($this->repo->find($user->id)->getModel()->projects($request->q, $request->orderBy)->get(), new ProjectTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Project
     * 
     * Display a list of paginated items .
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function paginatedProjects(Request $request, $id)
    {   
        try{
            $user = $this->repo->find($id)->getModel(); 
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->projects($request->q, $request->orderBy)->paginate($pagination), new ProjectTransformer);                 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->projects($request->q, $request->orderBy)->paginate(), new ProjectTransformer); 
            }   

            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    /**
     * Get all Review
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
            $user = $this->repo->find($id)->getModel();
            return ApiResponse::Collection($this->repo->find($user->id)->getModel()->reviews($request->q, $request->orderBy)->get(), new ReviewTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Review
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
            $user = $this->repo->find($id)->getModel();
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->reviews($request->q, $request->orderBy)->paginate($pagination), new ReviewTransformer);                 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->reviews($request->q, $request->orderBy)->paginate(), new ReviewTransformer); 
            }   

            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    /**
     * Get all Loading
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
            $user = $this->repo->find($id)->getModel();
            return ApiResponse::Collection($this->repo->find($user->id)->getModel()->loadings($request->q, $request->orderBy)->get(), new LoadingTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Paginated Loading
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
            $user = $this->repo->find($id)->getModel(); 
            if($pagination = $request->pagination){
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->loadings($request->q, $request->orderBy)->paginate($pagination), new LoadingTransformer);                 
            }
            else{
                return ApiResponse::Pagination($this->repo->find($user->id)->getModel()->loadings($request->q, $request->orderBy)->paginate(), new LoadingTransformer); 
            }   

            
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }

    /**
     * Attach Role
     *
     * Attach the Role to existing User.
     *
     * @param  App\Http\Requests\UserAttachRoleRequest  $request
     * @param  int  $id
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function attachRole(UserAttachRoleRequest $request, $id, $role_id)
    {
            $data = $request->only(array_keys($request->rules()));

            $user = $this->repo->find($id)->getModel();
	    	
	    $model = $this->roleRepo->find($role_id)->getModel();

            return ApiResponse::ItemAttached($this->repo->find($user->id)->attachRole($model, $data)->getModel(), $this->transformer);
    }
        

    /**
     * Attach Project
     *
     * Attach the Project to existing User.
     *
     * @param  App\Http\Requests\UserAttachProjectRequest  $request
     * @param  int  $id
     * @param  int  $project_id
     * @return \Illuminate\Http\Response
     */
    public function attachProject(UserAttachProjectRequest $request, $id, $project_id)
    {
            $data = $request->only(array_keys($request->rules()));

            $user = $this->repo->find($id)->getModel();
	    	
	    $model = $this->projectRepo->find($project_id)->getModel();

            return ApiResponse::ItemAttached($this->repo->find($user->id)->attachProject($model, $data)->getModel(), $this->transformer);
    }

    
    /**
     * Detach Role
     *
     * Detach the specified resource from existing resource.
     *    
     * @param  int  $id
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function detachRole($id, $role_id)
    {	    	
	$model = $this->roleRepo->find($role_id)->getModel();
        $user = $this->repo->find($id)->getModel();
        return ApiResponse::ItemDetached($this->repo->find($user->id)->detachRole($model)->getModel());
    }
    
    /**
     * Detach Project
     *
     * Detach the specified resource from existing resource.
     *
     * @param  int  $id
     * @param  int  $project_id
     * @return \Illuminate\Http\Response
     */
    public function detachProject($id, $project_id)
    {	    	
	$model = $this->projectRepo->find($project_id)->getModel();
        $user = $this->repo->find($id)->getModel();
        return ApiResponse::ItemDetached($this->repo->find($user->id)->detachProject($model)->getModel());
    }

}
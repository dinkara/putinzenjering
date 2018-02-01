<?php

namespace App\Http\Controllers\Auth;

use Dinkara\DinkoApi\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserAttachSocialNetworkRequest;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreUserRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\User\IUserRepo;
use App\Repositories\Profile\IProfileRepo;
use App\Repositories\SocialNetwork\ISocialNetworkRepo;
use App\Repositories\Role\IRoleRepo;
use App\Support\Enum\UserStatuses;
use App\Support\Enum\RoleTypes;
use App\Support\Enum\SocialNetworks;
use Socialite;
use Lang;
use ApiResponse;

/**
 * @resource Auth
 */
class AuthController extends ApiController {

    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @var ProfileRepository
     */
    private $profileRepo;
        
    /**
     * @var IRoleRepo 
     */
    private $roleRepo;
    
    /**
     * @var ISocialNetworkRepo 
     */
    private $socialNetworkRepo;
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(IUserRepo $userRepo, IProfileRepo $profileRepo, IRoleRepo $roleRepo, ISocialNetworkRepo $socialNetworkRepo) {
        $this->userRepo = $userRepo;
        $this->profileRepo = $profileRepo;
        $this->roleRepo = $roleRepo;
        $this->socialNetworkRepo = $socialNetworkRepo;
    }

    /**
     * Login
     * 
     * Returns unique user token
     * @param LoginRequest $request
     * @return type
     */
    public function login(LoginRequest $request) {
        $credentials = $request->only( "email", "password");     
        try {
            $this->invalidateJWTToken();
            // Attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponse::Unauthorized(Lang::get('auth.failed'));
            }
        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return ApiResponse::InternalError();
        }

        $user = JWTAuth::toUser($token);

        if ($user->status == UserStatuses::UNCONFIRMED) {
            return ApiResponse::Unauthorized(Lang::get('auth.confirm_email'));
        }

        if ($user->status == UserStatuses::BANNED) {
            return ApiResponse::Forbidden(Lang::get('auth.banned'));
        }

        if ($user->status == UserStatuses::DELETED) {
            return ApiResponse::Forbidden(Lang::get('auth.deleted'));
        }

        if($user->passwordReset){
            return ApiResponse::Unauthorized(Lang::get('passwords.reset_password_requested'));
        }

        return ApiResponse::Token(compact('token'));
    }
    
    
            
    /**
     * Facebook Auth
     * 
     * Login user via Facebook
     * @param UserAttachSocialNetworkRequest $request
     * @return type
     */
    public function facebookAuth(UserAttachSocialNetworkRequest $request)
    {         
        $token = $request->get(array_keys($request->rules())[0]);
        
        return $this->socialLogin($token, SocialNetworks::FACEBOOK);              
    }
    
    /**
     * Google Auth
     * 
     * Login user via Google
     * @param UserAttachSocialNetworkRequest $request
     * @return type
     */
    public function googleAuth(UserAttachSocialNetworkRequest $request)
    {         
        $token = $request->get(array_keys($request->rules())[0]);
        
        return $this->socialLogin($token, SocialNetworks::GOOGLE);              
    }
    
    private function socialLogin($token, $network)
    {                
        try {
            $user = Socialite::driver($network)->stateless()->user();
            
        } catch (\Exception $e) {            
            return ApiResponse::Unauthorized(Lang::get('auth.invalid_access_token'));
        }           
                
        try{
            $socialData = ["access_token" => $user->token, "provider_id" => $user->id];
            
            $userFacebook = $this->socialNetworkRepo->findBySocialId($user->id, $network);
            
            if(!$this->userRepo->findByEmail($user->email) && !$userFacebook){
                $register = ["email" => $user->email];                           
                
                $this->userRepo->register($register, false)
                                ->activate()
                                ->attachRole($this->roleRepo->findByName(RoleTypes::USER)->getModel())
                                ->attachSocialNetwork($this->socialNetworkRepo->findByName($network)->getModel(), $socialData);
                
                $profileData = ["user_id" => $this->userRepo->getModel()->id, "name" => $user->name];                
                $this->profileRepo->create($profileData);
                $userFacebook = $this->socialNetworkRepo->findBySocialId($user->id, $network);
            }
            
            if(!$userFacebook){                
                $this->userRepo->attachSocialNetwork($this->socialNetworkRepo->findByName($network)->getModel(), $socialData);
            }                
            else{
                //refresh Facebook access token
                //todo Refactor                
                $userFacebook->getModel()->pivot->update($socialData);
            }

            $token = JWTAuth::fromUser($this->userRepo->getModel());
            return ApiResponse::Token(compact('token'));
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }                 
    }

    /**
     * Logout
     * 
     * Logout user with passed token.
     * @return type
     */
    public function logout() {
        $this->invalidateJWTToken();
        return ApiResponse::SuccessMessage();
    }
    
    /**
     * Refresh token
     * 
     * Refresh token and get back to the client.
     * @return type
     */
    public function getToken() {
        $oldToken = JWTAuth::getToken();
        if (!$oldToken) {
            ApiResponse::Unauthorized(Lang::get('auth.invalid_token'));
        }
        try {         
            $token = JWTAuth::refresh($oldToken);
            $this->invalidateJWTToken();
        } catch (JWTException $e) {
            ApiResponse::InternalError(Lang::get('status.500'));
        }

        return ApiResponse::Token(compact('token'));
    }        

    /**
     * Register
     * 
     * Create new user
     * @param StoreUserRequest $request
     * @return type
     */
    public function register(StoreUserRequest $request) {

        try{
            $requestKeys = array_keys($request->rules());
            $userData = $request->only(array_intersect($requestKeys, $this->userRepo->getModel()->getFillable()));
            $profileData = $request->only(array_intersect($requestKeys, $this->profileRepo->getModel()->getFillable()));
            $this->userRepo->register($userData)->attachRole($this->roleRepo->findByName(RoleTypes::USER)->getModel());
            $profileData["user_id"] = $this->userRepo->getModel()->id;

            $this->profileRepo->create($profileData);

            return ApiResponse::SuccessMessage(Lang::get('auth.success_registration'));
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
    }
    
    /**
     * Confirm Email
     * 
     * Confirming user. Change status to active.
     * @param type $confirmation_code
     * @return type
     */
    public function confirmEmail($confirmation_code) {

        $user = $this->userRepo->validateEmail($confirmation_code);

        if($user)
            return ApiResponse::SuccessMessage(Lang::get('auth.success_confirmation'));
        else
            return ApiResponse::Unauthorized(Lang::get('auth.invalid_code'));
    }

}



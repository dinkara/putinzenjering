<?php

namespace App\Http\Controllers\Auth;

use Dinkara\DinkoApi\Http\Controllers\ApiController;
use Illuminate\Database\QueryException;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\User\IUserRepo;
use App\Repositories\PasswordReset\IPasswordResetRepo;
use Carbon\Carbon;
use Lang;
use ApiResponse;

/**
 * @resource ForgotPassword
 */
class ForgotPasswordController extends ApiController
{
    /**
     * @var UserRepository
     */
    private $userRepo;
    
    /**
     * @var PasswordResetRepository
     */
    private $passwordResetRepo;
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(IUserRepo $user, IPasswordResetRepo $passwordResetRepo)
    {
        $this->userRepo = $user;
        
        $this->passwordResetRepo = $passwordResetRepo;
    }

    /**
     * Forgot password
     * 
     * @param ForgotPasswordRequest $request
     * @return type
     */
    public function forgot(ForgotPasswordRequest $request){
        $email = $request->get("email");
        
        if(!$this->userRepo->findByEmail($email)){
            return ApiResponse::NotFound(Lang::get('passwords.user'));
        }
        
        $this->userRepo->sendForgotPasswordEmail();
        
        return ApiResponse::SuccessMessage(Lang::get('passwords.sent'));
    }
    
    /**
     * Reset password
     *  
     * @param ResetPasswordRequest $request
     * @return type
     */
    public function resetPassword(ResetPasswordRequest $request){
        $token = $request->get("token");
                
        $errors = [];
        if(!$errors && !$this->passwordResetRepo->findToken($token)){
            array_push($errors, Lang::get("passwords.token"));
        }
        
        if(!$errors && $this->passwordResetRepo->tokenExpired($token)){
            array_push($errors, Lang::get("passowrds.expired"));
        }
                
        $email = $request->get("email"); 
        
        if(!$errors && !$this->userRepo->findByEmail($email)){
           array_push($errors, Lang::get("passwords.user"));
        }                                        
                
        if(!$errors && $this->userRepo->passwordResetTokenMatch($token)){
            array_push($errors, Lang::get("passwords.token"));
        }
        
        $password = $request->get("password");
        
        if(!$errors && !$this->userRepo->resetPassword($password)){
            array_push($errors, Lang::get("passwords.failed"));
        }	
        
        if($errors){
            return ApiResponse::UnprocessableEntity($errors);
        }  
        
        try{
            $data['password_updated'] = Carbon::now();
            $this->userRepo->findByEmail($email)->getModel()->update($data);

            return ApiResponse::SuccessMessage(Lang::get('passwords.reset'));
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }                   
                
    }
}

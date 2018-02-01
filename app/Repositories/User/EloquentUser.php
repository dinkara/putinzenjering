<?php

namespace App\Repositories\User;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Repositories\Profile\IProfileRepo;
use App\Repositories\Role\IRoleRepo;
use App\Repositories\PasswordReset\IPasswordResetRepo;
use App\Repositories\SocialNetwork\ISocialNetworkRepo;
use App\Models\User;
use Mail;
use App\Mail\EmailConfirmation;
use App\Mail\ForgotPassword;
use App\Support\Enum\UserStatuses;
use App\Models\Role;
use App\Models\SocialNetwork;
use App\Models\Project;


class EloquentUser extends EloquentRepo implements IUserRepo {

    private $profileRepo;
    private $roleRepo;
    private $passwordResetRepo;
    private $socialNetworkRepo;

    public function __construct(IRoleRepo $roleRepo, IPasswordResetRepo $passwordResetRepo, IProfileRepo $profileRepo, ISocialNetworkRepo $socialNetworkRepo) {
        $this->roleRepo = $roleRepo;
        $this->passwordResetRepo = $passwordResetRepo;
        $this->profileRepo = $profileRepo;
        $this->socialNetworkRepo = $socialNetworkRepo;
    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new User;
    }
    
    public function register($fields, $sendEmail = true) {

        $fields["confirmation_code"] = $sendEmail ? str_random(30) : NULL;

        $result = $this->create($fields);

        if ($result && $sendEmail) {
            $this->sendConfirmationEmail();
        }

        return $this->finalize($result);
    }    

    public function validateEmail($confirmation_code) {
        $this->initialize();

        $this->model = $this->model->where("confirmation_code", $confirmation_code)->first();

        if ($this->model) {
            $this->update([
                "status" => UserStatuses::ACTIVE,
                "confirmation_code" => null
            ]);
        }

        return $this->finalize($this->model);
    }

    public function activate($id = null) {
        if ($id) {
            $this->find($id);
        }

        if (!$this->model) {
            return false;
        }

        return $this->update(["status" => UserStatuses::ACTIVE]);
    }

    public function sendConfirmationEmail() {
        $result = $this->update(["status" => UserStatuses::UNCONFIRMED]);

        if ($result) {
            $result = Mail::to($this->getModel())->send(new EmailConfirmation($this->getModel()));
        }

        return $this->finalize($result);
    }

    public function sendForgotPasswordEmail() {
        if (!$this->model) {
            return false;
        }

        $fields = ["user_id" => $this->getModel()->id, "token" => str_random(30)];


        if (!$this->model->passwordReset) {
            $result = $this->model->passwordReset()->save($this->passwordResetRepo->fill($fields)->getModel());
            $this->model->passwordReset = $this->passwordResetRepo->getModel();
        } else {
            $result = $this->model->passwordReset()->update($fields);
            $this->model->passwordReset->token = $fields["token"];
        }

        if ($result) {

            $result = Mail::to($this->getModel())->send(new ForgotPassword($this->getModel()));
        }

        return $this->finalize($result);
    }

    public function passwordResetTokenMatch($token) {
        if (!$this->model) {
            return false;
        }

        return $this->model->passwordReset->token != $token;
    }

    public function resetPassword($password) {
        if (!$this->model) {
            return false;
        }

        $this->model->password = $password;

        $this->model->passwordReset()->delete();

        return $this->finalize($this->save());
    }       

    public function banned($perPage = 15) {
        $this->initialize();
        
        $result = $this->model()->where("status", UserStatuses::BANNED)->paginate($perPage);
                
        return $result;
    }

    public function isBanned() {
        if (!$this->model) {
            return false;
        }

        $result = $this->model->status == UserStatuses::BANNED;
        
        return $result;
    }
    
    public function ban() {        
        if (!$this->model) {
            return false;
        }

        $result = $this->updateStatus(UserStatuses::BANNED);
        
        return $result;
        
    } 
    
    public function unban() {        
        if (!$this->model) {
            return false;
        }

        $result = $this->updateStatus(UserStatuses::ACTIVE);
        
        return $result;
        
    } 
    
    public function delete() {        
        if (!$this->model) {
            return false;
        }

        $this->updateStatus(UserStatuses::DELETED);        
        
        $result = $this->model->delete();
        
        return $result;
        
    }
    
    public function restore() { 
        
        if (!$this->model) {
            return false;
        }                
                
        if($result = $this->model->restore()){
        
            $result = $this->updateStatus(UserStatuses::ACTIVE);
        }
        
        return $result;
        
    }
    
    public function verify() {        
        if (!$this->model) {
            return false;
        }
                
        $result = $this->updateStatus(UserStatuses::ACTIVE);        
        
        return $result;
        
    }
    
    private function updateStatus($status) {        
        if (!$this->model) {
            return false;
        }

        $this->model->status = $status;                
        
        $result = $this->save();
        
        return $result;
        
    }
    
    public function attachRole(Role $model, array $data = []){
        if (!$this->model) {
            return false;
        }	
        
        $result = $this->model->roles()->attach($model, $data);
        
        return $this->finalize($this->model);
    }

    public function attachSocialNetwork(SocialNetwork $model, array $data = []){
        if (!$this->model) {
            return false;
        }	
        
        $result = $this->model->socialNetworks()->attach($model, $data);
        
        return $this->finalize($this->model);
    }

    public function attachProject(Project $model, array $data = []){
        if (!$this->model) {
            return false;
        }	
        
        $result = $this->model->projects()->attach($model, $data);
        
        return $this->finalize($this->model);
    }


    public function detachRole(Role $model){
        if (!$this->model) {
            return false;
        }
	
        $result = $this->model->roles()->detach($model);
        
        return $this->finalize($this->model);
    }

    public function detachSocialNetwork(SocialNetwork $model){
        if (!$this->model) {
            return false;
        }
	
        $result = $this->model->socialNetworks()->detach($model);
        
        return $this->finalize($this->model);
    }

    public function detachProject(Project $model){
        if (!$this->model) {
            return false;
        }
	
        $result = $this->model->projects()->detach($model);
        
        return $this->finalize($this->model);
    }



}

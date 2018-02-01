<?php

namespace App\Repositories\PasswordReset;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\PasswordReset;
use Carbon\Carbon;
class EloquentPasswordReset extends EloquentRepo implements IPasswordResetRepo
{

    const TOKEN_EXPIRATION_PERIOD = 24;
    
    /**
     * Configure the Model
     * */
    public function model() {
        return new PasswordReset;
    }

    public function findToken($token) {
        $this->initialize();

        $this->model = $this->model->where("token", $token)->first();

        return $this->finalize($this->model);
    }

    public function tokenExpired($token = null) {
        if($token){
            $this->findToken($token);
        }
        
        if (!$this->model) {
            return false;
        }
        
        $now = Carbon::now();
        
        $difference = $now->diffInHours($this->model->updated_at);
        
        return $difference > self::TOKEN_EXPIRATION_PERIOD;
    }

}
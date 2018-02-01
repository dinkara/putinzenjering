<?php

namespace App\Repositories\Profile;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Profile;

class EloquentProfile extends EloquentRepo implements IProfileRepo
{
    
    /**
     * Configure the Model
     * */
    public function model() {
        return new Profile;
    }

    public function findByUserID($id) {
        
        $this->initialize();

        $this->model = $this->model->where("user_id", $id)->first();

        return $this->finalize($this->model);
    }

}
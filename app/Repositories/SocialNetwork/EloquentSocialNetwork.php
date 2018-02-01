<?php

namespace App\Repositories\SocialNetwork;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\SocialNetwork;
use App\Support\Enum\SocialNetworks;

class EloquentSocialNetwork extends EloquentRepo implements ISocialNetworkRepo
{

    /**
     * Configure the Model
     * */
    public function model() {
        return new SocialNetwork;
    }

    public function findByName($name) {
        $this->initialize();

        $this->model = $this->model->where("name", $name)->first();

        return $this->finalize($this->model);
    }
    
    public function findByFacebookID($id) {
        return $this->findBySocialId($id, SocialNetworks::FACEBOOK);
    }

    //TO DO WRONG MODEL
    public function findBySocialId($id, $network) {
        $this->initialize();
                
        $this->model = $this->model->where("name", $network)->first();
        
        if($this->model){
            $this->model = $this->model->users()->where("provider_id", $id)->first();
        }
        
        return $this->finalize($this->model);
    }

}
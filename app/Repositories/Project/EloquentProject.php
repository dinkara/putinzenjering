<?php

namespace App\Repositories\Project;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Project;



class EloquentProject extends EloquentRepo implements IProjectRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Project;
    }
    

    

}

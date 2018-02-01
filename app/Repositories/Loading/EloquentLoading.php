<?php

namespace App\Repositories\Loading;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Loading;



class EloquentLoading extends EloquentRepo implements ILoadingRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Loading;
    }
    

    

}

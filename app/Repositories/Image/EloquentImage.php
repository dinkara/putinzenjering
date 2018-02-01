<?php

namespace App\Repositories\Image;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Image;



class EloquentImage extends EloquentRepo implements IImageRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Image;
    }
    

    

}

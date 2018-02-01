<?php

namespace App\Repositories\Category;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Category;



class EloquentCategory extends EloquentRepo implements ICategoryRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Category;
    }
    

    

}

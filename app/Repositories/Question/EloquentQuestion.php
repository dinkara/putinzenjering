<?php

namespace App\Repositories\Question;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Question;



class EloquentQuestion extends EloquentRepo implements IQuestionRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Question;
    }
    

    

}

<?php

namespace App\Repositories\Review;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Review;
use App\Models\Question;



class EloquentReview extends EloquentRepo implements IReviewRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Review;
    }
    
    public function attachQuestion(Question $model, array $data = []){
        if (!$this->model) {
            return false;
        }	
        
        $result = $this->model->questions()->attach($model, $data);
        
        return $this->finalize($this->model);
    }


    public function detachQuestion(Question $model){
        if (!$this->model) {
            return false;
        }
	
        $result = $this->model->questions()->detach($model);
        
        return $this->finalize($this->model);
    }

    

}

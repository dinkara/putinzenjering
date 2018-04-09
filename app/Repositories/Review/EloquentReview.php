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

    public function searchByRelation($q, $project_id, $order_id, $category_id) {  
        
        if (!$this->model)
            $this->initialize();
        
        $result = $this->createSearchByRelationQuery($q, $project_id, $order_id, $category_id);        
        
        return $result->get();
    }

    public function searchAndPaginateByRelation($q, $project_id, $order_id, $category_id, $perPage = 15) {  
        
        if (!$this->model)
            $this->initialize();
        
        $result = $this->createSearchByRelationQuery($q, $project_id, $order_id, $category_id);
        
        return $result->paginate($perPage);
    }
 
    private function createSearchByRelationQuery($q, $project_id, $order_id, $category_id){
        $result = $this->model()->with("order", "order.project", "questions", "user", "user.profile");

        if($q && $q != ''){
            $result = $result->where("description", 'like', '%'.$q.'%');            
        }
        
        if($order_id && $order_id != -1){
            $result = $result->where("order_id", $order_id);            
        }
        
        $result->whereHas('order', function($q) use ($project_id, $category_id){
        
            if($project_id && $project_id != -1){
                $q = $q->where("project_id", $project_id);            
            }

            if($category_id && $category_id != -1){
                $q = $q->where("category_id", $category_id);
            }
        
        }); 
        
        return $result;
    }
}

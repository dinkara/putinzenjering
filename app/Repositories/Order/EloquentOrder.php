<?php

namespace App\Repositories\Order;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Order;
use App\Support\Enum\OrderStatuses;
use App\Repositories\Project\IProjectRepo;

class EloquentOrder extends EloquentRepo implements IOrderRepo {

    protected $projectRepo;

    public function __construct(IProjectRepo $projectRepo) {

        $this->projectRepo = $projectRepo;
    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Order;
    }

    public function checkToUpdateStatus() {
        if (!$this->model) {
            return false;
        }
                        
        $reviews = $this->model->reviews;
        
        if($this->model->status != OrderStatuses::IN_PROGRESS && count($reviews) > 0 && count($reviews) < $this->model->quantity){
            $this->setStatus(OrderStatuses::IN_PROGRESS);
        }
                
        if(count($reviews) == $this->model->quantity){
            $status = true;                

            foreach($reviews as $review){
                $status = $status && $review->status();
            }
                    
            if($status){
                $this->setStatus(OrderStatuses::COMPLETED);
            }
            else{
                $this->setStatus(OrderStatuses::IN_PROGRESS);
            }
        }
                        
        $this->projectRepo->find($this->model->project_id)->checkToUpdateStatus();
        
        return $this->finalize($this->model);
    }

    private function setStatus($status){
        $this->model->status = $status;
        $result = $this->model->save();
        return $this->finalize($result);
    }
}

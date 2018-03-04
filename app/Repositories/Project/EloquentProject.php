<?php

namespace App\Repositories\Project;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Project;
use App\Support\Enum\ProjectStatuses;
use App\Support\Enum\OrderStatuses;

class EloquentProject extends EloquentRepo implements IProjectRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Project;
    }
    
    public function checkToUpdateStatus() {
        if (!$this->model) {
            return false;
        }
                        
        $orders = $this->model->orders;
        
        $status = true;
        
        foreach($orders as $order){
            $status = $status && ($order->status == OrderStatuses::COMPLETED);
        }
                
        if($status){
            return $this->setStatus(ProjectStatuses::READY_FOR_LOADING);
        }
        else{
            return $this->setStatus(ProjectStatuses::IN_PROGRESS);
        }
    }

    private function setStatus($status){
        $this->model->status = $status;
        $result = $this->model->save();
        return $this->finalize($result);
    }
    

}

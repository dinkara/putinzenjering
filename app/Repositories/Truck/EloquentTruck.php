<?php

namespace App\Repositories\Truck;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Truck;



class EloquentTruck extends EloquentRepo implements ITruckRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Truck;
    }
    

    

}

<?php

namespace App\Repositories\Order;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Order;



class EloquentOrder extends EloquentRepo implements IOrderRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Order;
    }
    

    

}

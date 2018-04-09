<?php

namespace App\Repositories\Order;

use Dinkara\RepoBuilder\Repositories\IRepo;

/**
 * Interface OrderRepository
 * @package App\Repositories\Order
 */
interface IOrderRepo extends IRepo {
   

    function checkToUpdateStatus();
    
    function searchByRelation($project_id, $category_id);
}
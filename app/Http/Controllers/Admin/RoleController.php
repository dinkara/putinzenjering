<?php

namespace App\Http\Controllers\Admin;

use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use App\Repositories\Role\IRoleRepo;
use App\Transformers\RoleTransformer;


/**
 * @resource Admin\Role
 */
class RoleController extends ResourceController
{        
    
    public function __construct(IRoleRepo $repo, RoleTransformer $transformer) {
        parent::__construct($repo, $transformer);

    }      

}
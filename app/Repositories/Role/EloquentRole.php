<?php

namespace App\Repositories\Role;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Role;

class EloquentRole extends EloquentRepo implements IRoleRepo
{

    /**
     * Configure the Model
     * */
    public function model() {
        return new Role;
    }
}
<?php

namespace App\Repositories\Project;

use Dinkara\RepoBuilder\Repositories\IRepo;
use App\Models\User;

/**
 * Interface ProjectRepository
 * @package App\Repositories\Project
 */
interface IProjectRepo extends IRepo {
   

    function checkToUpdateStatus();
    
    function attachUser(User $model, array $data = []);
    
    function detachUser(User $model);
}
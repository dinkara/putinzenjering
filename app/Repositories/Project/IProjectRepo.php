<?php

namespace App\Repositories\Project;

use Dinkara\RepoBuilder\Repositories\IRepo;

/**
 * Interface ProjectRepository
 * @package App\Repositories\Project
 */
interface IProjectRepo extends IRepo {
   

    function checkToUpdateStatus();
}
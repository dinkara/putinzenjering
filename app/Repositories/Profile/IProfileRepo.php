<?php

namespace App\Repositories\Profile;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Dinkara\RepoBuilder\Repositories\IRepo;

/**
 *
 * @author ndzak
 */
interface IProfileRepo extends IRepo{
    /**
     * Function that tries to find profile by user id
     * @param type $id
     */
    function findByUserID($id);
    
}

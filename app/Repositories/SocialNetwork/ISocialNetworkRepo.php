<?php

namespace App\Repositories\SocialNetwork;

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
interface ISocialNetworkRepo extends IRepo {
    
    /**
     * Function that tries to find Social Network based on given name
     * @param type $name
     */
    function findByName($name);
    
    /**
     * Function that tries to find user based on given facebook Id
     * @param type $id
     */
    function findByFacebookID($id);    
    
    /**
     * Function that tries to find user based on given social Id and network name
     * @param type $id
     */
    function findBySocialId($id, $network); 
    
}

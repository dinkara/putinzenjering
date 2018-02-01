<?php

namespace App\Repositories\PasswordReset;

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
interface IPasswordResetRepo extends IRepo{
    
    /**
     * Function that tries to find password reset record based on given token
     * @param type $token
     */
    function findToken($token);
    
    /**
     * If token if submitted it tries to find that token, and then checks how long it passed since reset was requested
     * @param type $token
     */
    function tokenExpired($token = null);
}

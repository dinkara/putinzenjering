<?php

namespace App\Repositories\User;

use Dinkara\RepoBuilder\Repositories\IRepo;
use App\Repositories\Profile\IProfileRepo;
use App\Models\Role;
use App\Models\SocialNetwork;
use App\Models\Project;

/**
 * Interface UserRepository
 * @package App\Repositories\User
 */
interface IUserRepo extends IRepo {
   
    
    /**
     * Function that creates new user
     * @param type $fields
     * @param type $sendEmail
     */
    function register($fields, $sendEmail = true);       
    
    /**
     * Function that validates user email
     * @param type $confirmation_code
     */
    function validateEmail($confirmation_code);
    
    /**
     * Function that sets user account to active state. If $id is submitted it tries to find user first
     * @param type $id
     */
    function activate($id = null);
    
    /**
     * Function that sends email to user, with instructions how to confirm his email
     */
    function sendConfirmationEmail();
    
    /**
     * Function that sends email to user with instructions how to reset his password
     */
    function sendForgotPasswordEmail();
    
    /**
     * Checks if password reset token matches with user email
     * @param type $token
     */
    function passwordResetTokenMatch($token);
    
    /**
     * Function that sets new user password
     * @param type $password
     */
    function resetPassword($password);    
    
    /**
     * Function that returns paginated list of all banned users
     * @param type $perPage
     */
    function banned($perPage = 15);
    
    /**
     * Function that checks if user inside repo is banned
     */    
    function isBanned();
    
    /**
     * Function that bans user account
     * @param type $status
     */
    function ban();
    
    /**
     * Function that unbans user account
     * @param type $status
     */
    function unban();
    
    /**
     * Function that restores deleted user account
     * @param type $status
     */
    function restore();
    
    /**
     * Function that verifies user account
     * @param type $status
     */
    function verify();
    
    function attachRole(Role $model, array $data = []);

    function attachSocialNetwork(SocialNetwork $model, array $data = []);

    function attachProject(Project $model, array $data = []);


    function detachRole(Role $model);

    function detachSocialNetwork(SocialNetwork $model);

    function detachProject(Project $model);


}
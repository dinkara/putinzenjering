<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Support\Enum;

/**
 * Description of UserStatuses
 *
 * @author Dinkic
 */
class UserStatuses {
    
    const NEW = "New";
    const UNCONFIRMED = "Unconfirmed";
    const ACTIVE = "Active";
    const BANNED = "Banned";
    const DELETED = "Deleted";

    
    public static function all() {
        return [
            self::NEW,
            self::UNCONFIRMED,
            self::ACTIVE,
            self::BANNED,
            self::DELETED,

        ];
    }
    
    public static function stringify(){
        return implode(",", self::all());
    }
}

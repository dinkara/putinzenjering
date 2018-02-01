<?php

namespace App\Support\Enum;

class RoleTypes
{
    const ADMIN = 'admin';
    const USER = 'user';  
    
    public static function all(){
        return [
            self::ADMIN,
            self::USER            
        ];
    }
    
    public static function stringify(){
        return implode(",", self::all());
    }
}
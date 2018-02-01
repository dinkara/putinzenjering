<?php

namespace App\Support\Enum;

class SocialNetworks
{
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';  
    
    public static function all(){
        return [
            self::FACEBOOK,
            self::GOOGLE            
        ];
    }
    
    public static function stringify(){
        return implode(",", self::all());
    }
}
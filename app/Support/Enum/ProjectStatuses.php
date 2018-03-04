<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Support\Enum;

/**
 * Description of ProjectStatuses
 *
 * @author Dinkic
 */
class ProjectStatuses {
    
    const IN_PROGRESS = "In progress";
    const READY_FOR_LOADING = "Ready for loading";
    const COMPLETED = "Completed";

    
    public static function all() {
        return [
            self::IN_PROGRESS,
            self::READY_FOR_LOADING,
            self::COMPLETED,

        ];
    }
    
    public static function stringify(){
        return implode(",", self::all());
    }
}

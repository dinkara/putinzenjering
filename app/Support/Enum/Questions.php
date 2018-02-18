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
class Questions {
    
    const WIDTH = "Ispravnost širine elementa";
    const LENGTH = "Ispravnost dužine elementa";
    const HEIGHT = "Ispravnost visine elementa";
    const ANKER = "Ispravnost ankera";
    const HOOK = "Ispravnost kuke";
    const PEIKKO = "Ispravnost Peikko";
    const VUTA = "Ispravnost vute";
    const HEAD = "Ispravnost glave";
    const THORNS = "Ispravnost trnova";
    const BOLCNA = "Ispravnost bolcni";
    const TILES = "Ispravnost pločice";
    const DAMAGE = "Oštećenja";
    const MARK = "Obeležavanje";
    
    public static function all() {
        return [
            self::WIDTH,
            self::LENGTH,
            self::HEIGHT,
            self::ANKER,
            self::HOOK,
            self::PEIKKO,
            self::VUTA,
            self::HEAD,
            self::THORNS,
            self::BOLCNA,
            self::TILES,
            self::DAMAGE,
            self::MARK,
        ];
    }
    
    public static function stringify(){
        return implode(",", self::all());
    }
}

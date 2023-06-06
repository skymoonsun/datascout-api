<?php

namespace App\Helper;

class IntegerHelper
{

    public static function selectMin($value1, $value2) {
        if ($value1 === null && $value2 === null) {
            return null;
        } elseif ($value1 === null) {
            return $value2;
        } elseif ($value2 === null) {
            return $value1;
        } else {
            return min($value1, $value2);
        }
    }

}
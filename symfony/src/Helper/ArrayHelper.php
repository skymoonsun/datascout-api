<?php

namespace App\Helper;

class ArrayHelper
{

    public static function arrayMultiSort($Array, $key1, $key2, $sort1, $sort2)
    {

        $tempArr = array();

        foreach($Array as $key=>$val) {
            $tempArr[$key1][$key] = $val->$key1;
            $tempArr[$key2][$key] = $val->$key2;
        }

        array_multisort($tempArr[$key1], $sort1, $tempArr[$key2], $sort2, $Array);

        return $Array;

    }

    public static function arrayMultiSort2($Array, $orderArray)
    {

        $tempArr = array();

        foreach($Array as $key=>$val) {
            for($i=0; $i<count($orderArray['orderType']); $i++){
                $tempArr[$orderArray['orderBy'][$i]][$key] = $val->$orderArray['orderBy'][$i];
            }
        }

        return $Array;

    }

    public static function searchForId($id, $array, $searchedKey) {
        foreach ($array as $key => $val) {
            if ($val[$searchedKey] === $id) {
                return true;
            }
        }
        return false;
    }

    public static function searchForId2($id, $array, $searchedKey) {
        foreach ($array as $key => $val) {
            if ($val[$searchedKey] === $id) {
                return $key;
            }
        }
        return false;
    }

    public static function searchForId3($id, $array, $searchedKey) {
        foreach ($array as $key => $val) {
            if ($val[$searchedKey] === $id) {
                return $array[$key];
            }
        }
        return false;
    }

    public static function findIndex($value, $array) {
        $index = null;
        foreach($array as $key => $item) {
            if($item == $value) {
                $index = $key;
                break;
            }
        }
        return $index;
    }

}
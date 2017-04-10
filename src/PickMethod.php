<?php

namespace FSth\Picker;

class PickMethod
{
    public static function random($result, $column)
    {
        if (empty($result) || !is_array($result)) {
            return '';
        }
        $rand = rand(0, count($result) - 1);
        if (empty($result[$rand]) || empty($result[$rand][$column])) {
            return '';
        }
        return $result[$rand][$column];
    }
}
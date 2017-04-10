<?php

namespace FSth\Picker;

class PickMethod
{
    public static function random($result)
    {
        if (empty($result) || !is_array($result)) {
            return [];
        }
        $rand = rand(0, count($result) - 1);
        return $result[$rand];
    }
}
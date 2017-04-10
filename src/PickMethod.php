<?php

namespace FSth\Picker;

class PickMethod
{
    public static function random($result, $nums = 1)
    {
        if (empty($result) || !is_array($result)) {
            return [];
        }
        $randomResult = self::randomMethod($result, $nums);
        return $nums == 1 ? $randomResult[0] : $randomResult;
    }

    private static function randomMethod($result, $times = 1)
    {
        $randKeys = [];
        $randResult = [];
        $randTimes = $times;
        $resultCount = count($result);
        if ($resultCount < $times) {
            return $result;
        }
        do {
            $randNum = rand(0, 99999);
            $randKey = $randNum % $resultCount;
            if (is_array($randKey)) {
                continue;
            }
            $randKeys[] = $randKey;
            $randResult[] = $result[$randKey];
            $randTimes--;
        } while ($randTimes > 0);
        return $randResult;
    }
}
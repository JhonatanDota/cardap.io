<?php

namespace App\Functions;

class Helpers
{
    /**
     * Check array has duplicated values.
     *
     * @param array $array
     * @return bool
     */
    public static function arrayHasDuplicatedValues(array $array): bool
    {
        $uniqueValues = array_unique($array);

        return count($array) !== count($uniqueValues);
    }
}

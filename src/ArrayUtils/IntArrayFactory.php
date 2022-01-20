<?php

namespace Gupalo\ArrayUtils;

class IntArrayFactory
{
    /**
     * @param array $a
     * @return int[]
     */
    public static function create(array $a): array
    {
        $result = [];
        foreach ($a as $v) {
            $result[] = (int)$v;
        }

        return $result;
    }

    /**
     * @param array $a
     * @return int[]
     */
    public static function createPreserveKeys(array $a): array
    {
        $result = [];
        foreach ($a as $k => $v) {
            $result[$k] = (int)$v;
        }

        return $result;
    }
}

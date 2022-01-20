<?php

namespace Gupalo\ArrayUtils;

class FloatArrayFactory
{
    /**
     * @param array $a
     * @return float[]
     */
    public static function create(array $a): array
    {
        $result = [];
        foreach ($a as $v) {
            $result[] = (float)$v;
        }

        return $result;
    }

    /**
     * @param array $a
     * @return float[]
     */
    public static function createPreserveKeys(array $a): array
    {
        $result = [];
        foreach ($a as $k => $v) {
            $result[$k] = (float)$v;
        }

        return $result;
    }
}

<?php

namespace Gupalo\ArrayUtils;

class ArrayFactory
{
    public static function createKeys(array $keys, $value = null): array
    {
        $result = [];

        foreach ($keys as $key) {
            $result[$key] = $value;
        }

        return $result;
    }

    public static function createDictionary(array $a, $keyColumn, $valueColumn): array
    {
        $result = [];
        foreach ($a as $item) {
            $result[$item[$keyColumn] ?? null] = $item[$valueColumn] ?? null;
        }

        return $result;
    }
}

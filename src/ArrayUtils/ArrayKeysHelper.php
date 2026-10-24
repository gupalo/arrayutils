<?php

namespace Gupalo\ArrayUtils;

class ArrayKeysHelper
{
    /**
     * @param array $a
     * @param array|string $keys
     * @return array
     */
    public static function index(array $a, array|string $keys = 'id'): array
    {
        $result = [];
        foreach ($a as $item) {
            $result[self::buildKeyForArrayItem($item, $keys)] = $item;
        }

        return $result;
    }

    /**
     * @param array $a
     * @param array|string $keys
     * @return array
     */
    public static function indexAndGroup(array $a, array|string $keys = 'id'): array
    {
        $result = [];
        foreach ($a as $item) {
            $result[self::buildKeyForArrayItem($item, $keys)][] = $item;
        }

        return $result;
    }

    private static function buildKeyForArrayItem(array $item, array|string $keys = 'id'): string
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $indexParts = [];
        foreach ($keys as $key) {
            $indexParts[] = (string)($item[$key] ?? '');
        }

        return implode('~', $indexParts);
    }

    public static function fill($a, $keys, $defaultValue = null): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = array_key_exists($key, $a) ? $a[$key] : $defaultValue;
        }

        return $result;
    }

    public static function filter(array $a, array $keys, $createMissingKeys = true): array
    {
        $result = [];
        foreach ($keys as $key) {
            if (!array_key_exists($key, $a) && !$createMissingKeys) {
                continue;
            }
            $value = $a[$key] ?? null;
            // cast numeric strings only when the number prints back as the same string: '031', '1.10'
            // and ids beyond int64 would otherwise lose zeros or saturate to PHP_INT_MAX
            if (is_string($value)) {
                if (preg_match('#^\d+$#', $value)) {
                    $int = (int)$value;
                    $value = (string)$int === $value ? $int : $value;
                } elseif (preg_match('#^\d+\.\d+$#', $value)) {
                    $float = round((float)$value, 8);
                    $value = (string)$float === $value ? $float : $value;
                }
            } elseif (is_float($value)) {
                $value = round($value, 8);
            }
            $result[$key] = $value;
        }

        return $result;
    }

    public static function unset(array $a, array $keys): array
    {
        return array_map(static function ($item) use ($keys) {
            foreach ($keys as $key) {
                unset($item[$key]);
            }

            return $item;
        }, $a);
    }
}

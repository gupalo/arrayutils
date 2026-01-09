<?php

namespace Gupalo\ArrayUtils;

class ArrayComparer
{
    /**
     * @param array $a1 Current values
     * @param array $a2 New state
     * @param array $keys Only these keys mean something
     * @return array[] [
     *      'created' => [key => new_value_from_a2],
     *      'updated' => [key => updated_fields_from_a2_with_id],
     *      'removed' => [key => id, key => id]
     * ]
     */
    public static function compare(array $a1, array $a2, array $keys, string $idField = 'id'): array
    {
        $result = ['created' => [], 'updated' => [], 'removed' => []];

        foreach ($a1 as $key => $value) {
            $id = $value[$idField] ?? $a2[$key][$idField] ?? null;

            $value = ArrayKeysHelper::filter($value, $keys);
            if (!array_key_exists($key, $a2)) {
                $result['removed'][$key] = $id;
                continue;
            }

            $value2 = ArrayKeysHelper::filter($a2[$key], $keys);
            $id ??= $value2[$idField] ?? null;
            $updated = self::compareOne($value, $value2, $keys);
            if ($updated) {
                if ($id && empty($updated[$idField])) {
                    $updated[$idField] = $id;
                }
                $result['updated'][$key] = $updated;
            }
        }
        foreach ($a2 as $key => $value) {
            if (!array_key_exists($key, $a1)) {
                $result['created'][$key] = ArrayKeysHelper::filter($value, $keys);
            }
        }

        return $result;
    }

    public static function compareFlat(array $a1, array $a2): array
    {
        $result = ['created' => [], 'updated' => [], 'removed' => []];

        foreach ($a1 as $key => $value) {
            if (!array_key_exists($key, $a2)) {
                $result['removed'][$key] = $value;
                continue;
            }

            if ((string)$value !== (string)$a2[$key]) {
                $result['updated'][$key] = $a2[$key];
            }
        }
        foreach ($a2 as $key => $value) {
            if (!array_key_exists($key, $a1)) {
                $result['created'][$key] = $value;
            }
        }

        return $result;
    }

    public static function compareOne(array $a1, array $a2, array $keys): array
    {
        $result = [];

        foreach ($keys as $key) {
            $v1 = $a1[$key] ?? null;
            $v2 = $a2[$key] ?? null;

            // compare float as rounded strings to make 0.01 === 0.0999999999999999
            if (self::isFloat($v1)) {
                $v1 = (string)round($v1, 8);
            }
            if (self::isFloat($v2)) {
                $v2 = (string)round($v2, 8);
            }

            if ((string)$v2 !== (string)$v1) {
                $result[$key] = $v2;
            }
        }

        return $result;
    }

    private static function isFloat(mixed $value): bool
    {
        return (bool)preg_match('#^-?\d+\.\d+$#', (string)$value);
    }
}

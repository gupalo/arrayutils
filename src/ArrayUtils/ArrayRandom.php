<?php

namespace Gupalo\ArrayUtils;

class ArrayRandom
{
    public static function pick(array $items): mixed
    {
        if (!$items) {
            return null;
        }

        return $items[array_rand($items)];
    }

    public static function pickMultiple(array $items, int $count = 1, bool $preserveKeys = false, mixed $default = []): mixed
    {
        if (!$items || $count < 1) {
            return $default;
        }

        $keys = array_rand($items, min($count, count($items)));
        if ($count === 1) {
            $keys = [$keys]; // array_rand returns "key" when count=1
        }

        $result = [];
        foreach ($keys as $key) {
            if ($preserveKeys) {
                $result[$key] = $items[$key];
            } else {
                $result[] = $items[$key];
            }
        }

        return $result;
    }
}

<?php

namespace Gupalo\ArrayUtils;

class ArrayUniquer
{
    public static function values(array $a): array
    {
        return array_values(array_unique($a));
    }

    public static function notNullValues(array $a): array
    {
        return array_values(array_unique(array_filter($a, static fn($v) => $v !== null)));
    }

    public static function columnValues(array $a, string $column): array
    {
        return array_values(array_unique(array_column($a, $column)));
    }

    public static function mergeValues(...$a): array
    {
        return array_values(array_unique(array_merge(...$a)));
    }

    public static function mergeNotNullValues(...$a): array
    {
        return array_values(array_unique(array_filter(array_merge(...$a), static fn($v) => $v !== null)));
    }
}

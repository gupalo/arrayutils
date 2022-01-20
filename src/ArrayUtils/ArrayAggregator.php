<?php

namespace Gupalo\ArrayUtils;

use Symfony\Component\PropertyAccess\PropertyAccessor;

class ArrayAggregator
{
    public static function max($items, string $field): int|float
    {
        $propertyAccessor = new PropertyAccessor();

        $result = 0;
        foreach ($items as $item) {
            if (is_array($item)) {
                $value = $item[$field] ?? 0;
            } else {
                $value = $propertyAccessor->getValue($item, $field) ?? 0;
            }

            if ($value > $result) {
                $result = $value;
            }
        }

        return $result;
    }

    public static function maxRatio($items, string $field, string $field2): float
    {
        $propertyAccessor = new PropertyAccessor();

        $result = 0;
        foreach ($items as $item) {
            if (is_array($item)) {
                $value = $item[$field] ?? 0;
                $value2 = $item[$field2] ?? 0;
            } else {
                $value = $propertyAccessor->getValue($item, $field) ?? 0;
                $value2 = $propertyAccessor->getValue($item, $field2) ?? 0;
            }
            if ($value2 > 0 && $value / $value2 > $result) {
                $result = $value / $value2;
            }
        }

        return $result;
    }

    public static function sum($items, string $field): int|float
    {
        $propertyAccessor = new PropertyAccessor();

        $result = 0;
        foreach ($items as $item) {
            if (is_array($item)) {
                $value = $item[$field] ?? 0;
            } else {
                $value = $propertyAccessor->getValue($item, $field) ?? 0;
            }

            $result += $value;
        }

        return $result;
    }

    public static function ratio($items, string $field, string $field2): ?float
    {
        $sum = self::sum($items, $field);
        $sum2 = self::sum($items, $field2);

        return $sum2 ? $sum / $sum2 : null;
    }
}

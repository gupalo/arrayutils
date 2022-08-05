<?php

namespace Gupalo\ArrayUtils;

class ArrayTable
{
    /**
     * @param array $data [ [k1, k2], [v1.1, v1.2],             [v2.1, v2.2]             ]
     * @return array      [           [k1 => v1.1, k2 => v1.2], [k1 => v2.1, k2 => v2.2] ]
     */
    public static function arrayToKeyValues(array $data): array
    {
        $data = array_values($data);
        if (empty($data)) {
            return [];
        }

        $keys = array_values($data[0]);
        $jMax = count($keys);
        $result = [];
        for ($i = 1, $iMax = count($data); $i < $iMax; $i++) {
            $item = [];
            for ($j = 0; $j < $jMax; $j++) {
                $item[$keys[$j]] = $data[$i][$j] ?? null;
            }
            if ($item) {
                $result[] = $item;
            }
        }

        return $result;
    }
}

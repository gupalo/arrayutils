<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\ArrayComparer;
use PHPUnit\Framework\TestCase;

class ArrayComparerTest extends TestCase
{
    public function testCompareOne(): void
    {
        $a = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'same' => 100.01];
        $b = ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2', 'same' => '100.0100000'];
        $expected = ['k1' => null, 'k3' => 'v3.2', 'k4' => 'v4'];

        self::assertSame($expected, ArrayComparer::compareOne($a, $b, ['k1', 'k2', 'k3', 'k4', 'same']));
    }

    public function testCompare(): void
    {
        $a = [
            'd1' => ['id' => 'id_d1', 'k1' => 'old'],
            'd2' => ['id' => 'id_d2', 'k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1'],
        ];
        $b = [
            'd3' => ['id' => 'id_d3', 'k1' => 'new'],
            'd2' => ['id' => 'id_d2', 'k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
        ];
        $expected = [
            'created' => [
                'd3' => ['k1' => 'new', 'k2' => null, 'k3' => null, 'k4' => null,],
            ],
            'updated' => [
                'd2' => ['k1' => null, 'k3' => 'v3.2', 'k4' => 'v4', 'id' => 'id_d2'],
            ],
            'removed' => [
                'd1' => 'id_d1',
            ],
        ];

        self::assertSame($expected, ArrayComparer::compare($a, $b, ['k1', 'k2', 'k3', 'k4']));
    }

    public function testCompareFlat(): void
    {
        $a = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'removed' => null];
        $b = ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'];
        $expected = [
            'created' => ['k4' => 'v4', 'skip2' => '2'],
            'updated' => ['k3' => 'v3.2'],
            'removed' => ['k1' => 'v1', 'skip1' => '1', 'removed' => null],
        ];

        self::assertSame($expected, ArrayComparer::compareFlat($a, $b));
    }
}

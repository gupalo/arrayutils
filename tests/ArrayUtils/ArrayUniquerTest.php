<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\ArrayUniquer;
use PHPUnit\Framework\TestCase;

class ArrayUniquerTest extends TestCase
{
    public function testValues(): void
    {
        $a = ['k1' => 5, 'k2' => 7, 'k3' => 5, 'k4' => 'a', 'k5' => 'a', 5, 'a', '', 0];
        $expected = [5, 7, 'a', '', 0];

        self::assertSame($expected, ArrayUniquer::values($a));
    }

    public function testMergeValues(): void
    {
        $expected = [5, 7, 'a', '', 0];

        self::assertSame($expected, ArrayUniquer::mergeValues(
            ['k1' => 5, 'k2' => 7, 'k3' => 5], ['k4' => 'a', 'k5' => 'a', 5], ['a', '', 0]
        ));
    }

    public function testNotNullValues(): void
    {
        $a = [null, 'k1' => 5, 'k2' => 7, 'k3' => 5, 'k4' => 'a', 'k5' => 'a', 'k6' => null, 5, 'a', '', 0];
        $expected = [5, 7, 'a', '', 0];

        self::assertSame($expected, ArrayUniquer::notNullValues($a));
    }

    public function testMergeNotNullValues(): void
    {
        $expected = [5, 7, 'a', '', 0];

        self::assertSame($expected, ArrayUniquer::mergeNotNullValues(
            [null, 'k1' => 5], ['k2' => 7, 'k3' => 5, 'k4' => 'a'], ['k5' => 'a', 'k6' => null, 5, 'a', '', 0]
        ));
    }

    public function testColumnValues(): void
    {
        $a = [
            ['k' => null],
            ['k' => 5, 'k2' => 7,],
            ['k3' => 5, 'k' => 'a'],
            ['k' => 'a', 'k6' => null],
            ['k' => 5, 'a', '', 0],
        ];
        $expected = [null, 5, 'a'];

        self::assertSame($expected, ArrayUniquer::columnValues($a, 'k'));
    }
}

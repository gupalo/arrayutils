<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\ArrayAggregator;
use PHPUnit\Framework\TestCase;

class ArrayAggregatorTest extends TestCase
{
    public function testSum(): void
    {
        $items = [
            ['k1' => 3, 'k2' => 10,],
            ['k1' => 5, 'k2' => 100,],
            ['k1' => -10,],
        ];

        self::assertSame(-2, ArrayAggregator::sum($items, 'k1'));
    }

    public function testRatio(): void
    {
        $items = [
            ['k1' => 3, 'k2' => 30,],
            ['k1' => 5, 'k2' => 100,],
            ['k1' => 7, 'k2' => 14],
        ];

        self::assertSame(15 / 144, ArrayAggregator::ratio($items, 'k1', 'k2'));

        self::assertNull(ArrayAggregator::ratio([], 'k1', 'k2'));
        self::assertNull(ArrayAggregator::ratio([['k1' => 0, 'k2' => 0]], 'k1', 'k2'));
        self::assertSame(0.0, ArrayAggregator::ratio([['k1' => 0, 'k2' => 1.23]], 'k1', 'k2'));
    }

    public function testMax(): void
    {
        $items = [
            ['k1' => 3, 'k2' => 10,],
            ['k1' => 5, 'k2' => 100,],
            ['k1' => -10,],
        ];

        self::assertSame(5, ArrayAggregator::max($items, 'k1'));
    }

    public function testMaxRatio(): void
    {
        $items = [
            ['k1' => 3, 'k2' => 30,],
            ['k1' => 5, 'k2' => 100,],
            ['k1' => 7, 'k2' => 14],
        ];

        self::assertSame(0.5, ArrayAggregator::maxRatio($items, 'k1', 'k2'));
    }
}

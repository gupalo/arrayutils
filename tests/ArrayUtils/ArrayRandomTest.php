<?php

namespace Gupalo\Tests\ArrayUtils;

use Generator;
use Gupalo\ArrayUtils\ArrayRandom;
use PHPUnit\Framework\TestCase;

class ArrayRandomTest extends TestCase
{
    public function testPick(): void
    {
        self::assertNull(ArrayRandom::pick([]));
        self::assertTrue(ArrayRandom::pick([true]));
        self::assertSame(1, ArrayRandom::pick([1]));
        self::assertSame('1', ArrayRandom::pick(['1']));
        self::assertSame('1', ArrayRandom::pick(['1', '1', '1']));
        self::assertContains(ArrayRandom::pick(['a', 'b', 'c']), ['a', 'b', 'c']);
    }

    public function testPickMultiple(): void
    {
        self::assertSame([], ArrayRandom::pickMultiple([]));
        self::assertNull(ArrayRandom::pickMultiple([], default: null));
        self::assertSame([true], ArrayRandom::pickMultiple([true]));
        self::assertSame([1], ArrayRandom::pickMultiple([1]));
        self::assertSame(['1'], ArrayRandom::pickMultiple(['1']));
        self::assertSame(['1'], ArrayRandom::pickMultiple(['1', '1', '1'], preserveKeys: false));
        self::assertContains(ArrayRandom::pickMultiple(['a', 'b', 'c']), [['a'], ['b'], ['c']]);

        self::assertContains(ArrayRandom::pickMultiple(['a', 'b'], count: 2), [['a', 'b'], ['b', 'a']]);
        self::assertContains(ArrayRandom::pickMultiple($this->generator(), count: 2), [['a', 'b'], ['b', 'a']]);
        self::assertContains(ArrayRandom::pickMultiple(['k1' => 'a', 'k2' => 'b'], count: 2), [['a', 'b'], ['b', 'a']]);
        self::assertContains(ArrayRandom::pickMultiple(['k1' => 'a', 'k2' => 'b'], count: 2, preserveKeys: true), [['k1' => 'a', 'k2' => 'b'], ['k2' => 'b', 'k1' => 'a']]);

        self::assertContains(ArrayRandom::pickMultiple(['k1' => 'a', 'k2' => 'b'], count: 100, preserveKeys: true), [['k1' => 'a', 'k2' => 'b'], ['k2' => 'b', 'k1' => 'a']]);
    }

    public function testPickMultiple_MoreThanCountElements(): void
    {
        self::assertSame(ArrayRandom::pickMultiple(['qqq'], count: 3), ['qqq']);
    }

    private function generator(): Generator
    {
        yield 'a';
        yield 'b';
    }
}

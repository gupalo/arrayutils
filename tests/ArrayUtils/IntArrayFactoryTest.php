<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\IntArrayFactory;
use PHPUnit\Framework\TestCase;

class IntArrayFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $a = ['k1' => '5', 'k2' => '7.0', 'k3' => '8.2', 'k4' => 5, 'k5' => 7.0, 'k6' => 8.2];

        self::assertSame([5, 7, 8, 5, 7, 8], IntArrayFactory::create($a));
    }

    public function testCreatePreserveKeys(): void
    {
        $a = ['k1' => '5', 'k2' => '7.0', 'k3' => '8.2', 'k4' => 5, 'k5' => 7.0, 'k6' => 8.2];
        $expected = ['k1' => 5, 'k2' => 7, 'k3' => 8, 'k4' => 5, 'k5' => 7, 'k6' => 8];

        self::assertSame($expected, IntArrayFactory::createPreserveKeys($a));
        self::assertSame(array_keys($expected), array_keys(IntArrayFactory::createPreserveKeys($a)));
    }
}

<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\FloatArrayFactory;
use PHPUnit\Framework\TestCase;

class FloatArrayFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $a = ['k1' => '5', 'k2' => '7.0', 'k3' => '8.2', 'k4' => 5, 'k5' => 7.0, 'k6' => 8.2];

        self::assertSame([5.0, 7.0, 8.2, 5.0, 7.0, 8.2], FloatArrayFactory::create($a));
    }

    public function testCreatePreserveKeys(): void
    {
        $a = ['k1' => '5', 'k2' => '7.0', 'k3' => '8.2', 'k4' => 5, 'k5' => 7.0, 'k6' => 8.2];
        $expected = ['k1' => 5.0, 'k2' => 7.0, 'k3' => 8.2, 'k4' => 5.0, 'k5' => 7.0, 'k6' => 8.2];

        self::assertSame($expected, FloatArrayFactory::createPreserveKeys($a));
        self::assertSame(array_keys($expected), array_keys(FloatArrayFactory::createPreserveKeys($a)));
    }
}

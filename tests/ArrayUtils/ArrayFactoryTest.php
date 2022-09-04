<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\ArrayFactory;
use PHPUnit\Framework\TestCase;

class ArrayFactoryTest extends TestCase
{
    public function testCreateWithKeys(): void
    {
        self::assertSame(['k1' => null, 'k2' => null], ArrayFactory::createKeys(['k1', 'k2']));

        self::assertSame(['k1' => 'test', 'k2' => 'test'], ArrayFactory::createKeys(['k1', 'k2'], 'test'));
    }

    public function testCreateDictionary(): void
    {
        $a = [
            ['k' => 'a1', 'v' => 'b1'],
            ['k' => 'a2', 'v' => 'b2'],
        ];
        self::assertSame(['a1' => 'b1', 'a2' => 'b2'], ArrayFactory::createDictionary($a, 'k', 'v'));
    }
}

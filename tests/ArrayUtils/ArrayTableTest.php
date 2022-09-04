<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\ArrayTable;
use PHPUnit\Framework\TestCase;

class ArrayTableTest extends TestCase
{
    public function testArrayToKeyValues(): void
    {
        $array = [
            ['key1', 'key2',],
            ['r1.1', 'r1.2'],
            ['r2.1', 'r2.2', 'r2.3'],
            ['r3.1'],
        ];

        $result = [
            ['key1' => 'r1.1', 'key2' => 'r1.2'],
            ['key1' => 'r2.1', 'key2' => 'r2.2'],
            ['key1' => 'r3.1', 'key2' => null],
        ];

        self::assertSame($result, ArrayTable::arrayToKeyValues($array));
    }
}

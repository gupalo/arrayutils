<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\ArrayKeysHelper;
use PHPUnit\Framework\TestCase;

class ArrayKeysHelperTest extends TestCase
{
    public function testIndex(): void
    {
        $a = [
            ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'removed' => null],
            ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
        ];
        $aIndexed1 = [
            'v3.1' => ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'removed' => null],
            'v3.2' => ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
        ];
        $aIndexed2 = [
            'v2~1~' => ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'removed' => null],
            'v2~~2' => ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
        ];

        self::assertSame($aIndexed1, ArrayKeysHelper::index($a, 'k3'));
        self::assertSame($aIndexed2, ArrayKeysHelper::index($a, ['k2', 'skip1', 'skip2']));
    }

    public function testFilter(): void
    {
        $a = ['k1' => 'v1', 'k2' => 'v2', 'k4' => -100.009999999999999999999999];
        $expected = ['k1' => 'v1', 'k3' => null, 'k4' => -100.01];

        self::assertSame($expected, ArrayKeysHelper::filter($a, ['k1', 'k3', 'k4']));
    }

    public function testFilter_NotCreateMissing(): void
    {
        $a = ['k1' => 'v1', 'k2' => 'v2'];
        $expected = ['k1' => 'v1'];

        self::assertSame($expected, ArrayKeysHelper::filter($a, ['k1', 'k3'], false));
    }

    public function testFill(): void
    {
        $a = ['k1' => 'v1', 'k2' => 'v2'];
        $b = ArrayKeysHelper::fill($a, ['k1', 'k3'], 5);

        self::assertSame(['k1' => 'v1', 'k3' => 5], $b);
    }

    public function testUnset(): void
    {
        $a = [
            ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'],
            ['k1' => 'v2', 'k2' => 'v2'],
        ];
        $expected = [
            ['k1' => 'v1',],
            ['k1' => 'v2',],
        ];

        self::assertSame($expected, ArrayKeysHelper::unset($a, ['k3', 'k2']));
    }
}

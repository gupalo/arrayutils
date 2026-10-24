<?php

namespace Gupalo\Tests\ArrayUtils;

use Gupalo\ArrayUtils\ArrayKeysHelper;
use PHPUnit\Framework\Attributes\DataProvider;
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

    public function testIndexGroup(): void
    {
        $a = [
            ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'removed' => null],
            ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
            ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
        ];
        $aIndexed1 = [
            'v3.1' => [
                ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'removed' => null],
            ],
            'v3.2' => [
                ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
                ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
            ],
        ];
        $aIndexed2 = [
            'v2~1~' => [
                ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3.1', 'skip1' => '1', 'removed' => null],
            ],
            'v2~~2' => [
                ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
                ['k3' => 'v3.2', 'k2' => 'v2', 'k4' => 'v4', 'skip2' => '2'],
            ]
        ];

        self::assertSame($aIndexed1, ArrayKeysHelper::indexAndGroup($a, 'k3'));
        self::assertSame($aIndexed2, ArrayKeysHelper::indexAndGroup($a, ['k2', 'skip1', 'skip2']));
    }

    public function testFilter(): void
    {
        $a = ['k1' => 'v1', 'k2' => 'v2', 'k4' => -100.009999999999999999999999];
        $expected = ['k1' => 'v1', 'k3' => null, 'k4' => -100.01];

        self::assertSame($expected, ArrayKeysHelper::filter($a, ['k1', 'k3', 'k4']));
    }

    #[DataProvider('dataFilter_CastsOnlyWhenRoundTripIsExact')]
    public function testFilter_CastsOnlyWhenRoundTripIsExact(string $value, int|float|string $expected): void
    {
        self::assertSame(['k' => $expected], ArrayKeysHelper::filter(['k' => $value], ['k']));
    }

    public static function dataFilter_CastsOnlyWhenRoundTripIsExact(): array
    {
        return [
            'int' => ['31', 31],
            'zero' => ['0', 0],
            'int64 max' => ['9223372036854775807', PHP_INT_MAX],
            'leading zero stays string' => ['031', '031'],
            'beyond int64 stays string' => ['15822091625119787669899590652011', '15822091625119787669899590652011'],
            'float' => ['1.5', 1.5],
            'trailing zero stays string' => ['1.10', '1.10'],
            'decimal column text stays string' => ['10.500000', '10.500000'],
            'more than 8 decimals stays string' => ['0.123456789', '0.123456789'],
            'leading zero float stays string' => ['01.5', '01.5'],
            'non-numeric' => ['abc', 'abc'],
        ];
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

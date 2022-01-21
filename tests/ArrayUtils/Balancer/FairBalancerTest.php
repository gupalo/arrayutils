<?php

namespace Gupalo\Tests\ArrayUtils\Balancer;

use Gupalo\ArrayUtils\Balancer\Bucket;
use Gupalo\ArrayUtils\Balancer\FairBalancer;
use PHPUnit\Framework\TestCase;

class FairBalancerTest extends TestCase
{
    public function testAddItem(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new FairBalancer([$bucket1, $bucket2, $bucket3], seed: 'test_seed');

        self::assertSame($bucket1, $balancer->chooseBucket());
        self::assertSame($bucket3, $balancer->chooseBucket());
        self::assertSame($bucket2, $balancer->chooseBucket());
        self::assertSame($bucket3, $balancer->chooseBucket());
    }

    public function testAddItem_NoSeed_CannotBeSameWhileNotFilled(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new FairBalancer([$bucket1, $bucket2, $bucket3]);

        $countSame = 0;
        $prevBucket = null;
        for ($i = 0; $i < 3; $i++) {
            $bucket = $balancer->chooseBucket();

            if ($prevBucket === $bucket) {
                $countSame++;
            }
            $prevBucket = $bucket;
        }
        self::assertSame(0, $countSame);
    }

    public function testAddItem_NoSeed_CannotBeMoreThanFilledTimes(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new FairBalancer([$bucket1, $bucket2, $bucket3]);

        $countSame = 0;
        $prevBucket = null;
        for ($i = 0; $i < 9; $i++) {
            $bucket = $balancer->chooseBucket();

            if ($prevBucket === $bucket) {
                $countSame++;
            }
            $prevBucket = $bucket;
        }
        self::assertLessThan(3, $countSame);
    }
}

<?php

namespace Gupalo\Tests\ArrayUtils\Balancer;

use Gupalo\ArrayUtils\Balancer\BalancerBucket;
use Gupalo\ArrayUtils\Balancer\FairBalancer;
use PHPUnit\Framework\TestCase;

class FairBalancerTest extends TestCase
{
    public function testAddItem(): void
    {
        $bucket1 = new BalancerBucket('test1');
        $bucket2 = new BalancerBucket('test2');
        $bucket3 = new BalancerBucket('test3');

        $balancer = new FairBalancer([$bucket1, $bucket2, $bucket3], seed: 'test_seed');

        self::assertSame($bucket1, $balancer->addItem());
        self::assertSame($bucket3, $balancer->addItem());
        self::assertSame($bucket2, $balancer->addItem());
        self::assertSame($bucket3, $balancer->addItem());
    }

    public function testAddItem_NoSeed_CannotBeSameWhileNotFilled(): void
    {
        $bucket1 = new BalancerBucket('test1');
        $bucket2 = new BalancerBucket('test2');
        $bucket3 = new BalancerBucket('test3');

        $balancer = new FairBalancer([$bucket1, $bucket2, $bucket3]);

        $countSame = 0;
        $prevBucket = null;
        for ($i = 0; $i < 3; $i++) {
            $bucket = $balancer->addItem();

            if ($prevBucket === $bucket) {
                $countSame++;
            }
            $prevBucket = $bucket;
        }
        self::assertSame(0, $countSame);
    }

    public function testAddItem_NoSeed_CannotBeMoreThanFilledTimes(): void
    {
        $bucket1 = new BalancerBucket('test1');
        $bucket2 = new BalancerBucket('test2');
        $bucket3 = new BalancerBucket('test3');

        $balancer = new FairBalancer([$bucket1, $bucket2, $bucket3]);

        $countSame = 0;
        $prevBucket = null;
        for ($i = 0; $i < 9; $i++) {
            $bucket = $balancer->addItem();

            if ($prevBucket === $bucket) {
                $countSame++;
            }
            $prevBucket = $bucket;
        }
        self::assertLessThan(3, $countSame);
    }
}

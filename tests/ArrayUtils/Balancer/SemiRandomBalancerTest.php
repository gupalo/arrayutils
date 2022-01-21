<?php

namespace Gupalo\Tests\ArrayUtils\Balancer;

use Gupalo\ArrayUtils\Balancer\Bucket;
use Gupalo\ArrayUtils\Balancer\SemiRandomBalancer;
use PHPUnit\Framework\TestCase;

class SemiRandomBalancerTest extends TestCase
{
    public function testAddItem(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new SemiRandomBalancer([$bucket1, $bucket2, $bucket3], randomStrategyProbability: 1.0, seed: 'test_seed');

        self::assertSame($bucket1, $balancer->chooseBucket());
        self::assertSame($bucket2, $balancer->chooseBucket());
        self::assertSame($bucket3, $balancer->chooseBucket());
        self::assertSame($bucket3, $balancer->chooseBucket());
    }
    public function testAddItem_NoRandom(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new SemiRandomBalancer([$bucket1, $bucket2, $bucket3], randomStrategyProbability: 0.0, seed: 'test_seed');

        self::assertSame($bucket1, $balancer->chooseBucket());
        self::assertSame($bucket3, $balancer->chooseBucket());
        self::assertSame($bucket2, $balancer->chooseBucket());
        self::assertSame($bucket3, $balancer->chooseBucket());
    }

    public function testAddItem_SometimesDifferentButEventuallyEqual(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new SemiRandomBalancer([$bucket1, $bucket2, $bucket3], randomStrategyProbability: 0.5, seed: 'test_seed');

        $maxDiff = 0;
        for ($i = 0; $i < 99; $i++) {
            $balancer->chooseBucket();
            
            $min = min($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());
            $max = max($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());
            
            $maxDiff = max($maxDiff, $max - $min);
        }
        
        self::assertSame(5, $maxDiff);
        
        self::assertSame(33, $bucket1->getCount());
        self::assertSame(33, $bucket2->getCount());
        self::assertSame(33, $bucket3->getCount());
    }

    public function testAddItem_SometimesDifferentButEventuallyEqual_HigherRandom(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new SemiRandomBalancer([$bucket1, $bucket2, $bucket3], randomStrategyProbability: 0.9, seed: 'test_seed');

        $maxDiff = 0;
        for ($i = 0; $i < 99; $i++) {
            $balancer->chooseBucket();

            $min = min($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());
            $max = max($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());

            $maxDiff = max($maxDiff, $max - $min);
        }

        self::assertSame(9, $maxDiff);

        self::assertSame(34, $bucket1->getCount());
        self::assertSame(33, $bucket2->getCount());
        self::assertSame(32, $bucket3->getCount());
    }

    public function testAddItem_SometimesDifferentButEventuallyEqual_Prefilled(): void
    {
        $bucket1 = new Bucket('test1');
        $bucket2 = new Bucket('test2');
        $bucket3 = new Bucket('test3');

        $balancer = new SemiRandomBalancer([$bucket1, $bucket2, $bucket3], randomStrategyProbability: 0.5, seed: 'test_seed');

        // prefill test1 & test2; keep test3 empty
        for ($i = 0; $i < 50/2; $i++) {
            $bucket1->addItem();
            $bucket2->addItem();
        }

        $maxDiff = 0;
        for ($i = 0; $i < 10; $i++) {
            $balancer->chooseBucket();

            $min = min($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());
            $max = max($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());

            $maxDiff = max($maxDiff, $max - $min);
        }
        self::assertSame(25, $maxDiff); // difference is not increasing
        self::assertSame(25+2, $bucket1->getCount()); // added 2 to test1
        self::assertSame(25+2, $bucket2->getCount()); // added 2 to test2
        self::assertSame(6, $bucket3->getCount()); // added 6 to test3

        $maxDiff = 0;
        for ($i = 0; $i < 39; $i++) {
            $balancer->chooseBucket();

            $min = min($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());
            $max = max($bucket1->getCount(), $bucket2->getCount(), $bucket3->getCount());

            $maxDiff = max($maxDiff, $max - $min);
        }
        self::assertSame(23, $maxDiff); // difference is not increasing
        self::assertSame(34, $bucket1->getCount());
        self::assertSame(33, $bucket2->getCount());
        self::assertSame(32, $bucket3->getCount());
    }
}

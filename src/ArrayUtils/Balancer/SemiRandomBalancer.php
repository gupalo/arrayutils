<?php

/** @noinspection PhpSameParameterValueInspection */

namespace Gupalo\ArrayUtils\Balancer;

class SemiRandomBalancer extends FairBalancer
{
    private float $randomStrategyProbability;

    public function __construct(
        array $buckets,
        float $randomStrategyProbability = 0.7,
        string $seed = '',
    ) {
        parent::__construct($buckets, $seed);

        $this->randomStrategyProbability = $randomStrategyProbability;
    }

    public function chooseBucket(): BucketInterface
    {
        $this->validateBuckets();

        if ($this->isRandomStrategy()) {
            $buckets = $this->buckets;
        } else {
            $buckets = $this->selectMinCountBuckets();
        }

        return $this->pickRandomBucket($buckets);
    }

    private function isRandomStrategy(): bool
    {
        return $this->random(999) < (int)round($this->randomStrategyProbability * 1000);
    }
}

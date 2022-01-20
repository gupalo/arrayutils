<?php

namespace Gupalo\ArrayUtils\Balancer;

use LogicException;
use Throwable;

class FairBalancer implements BalancerInterface
{
    /** @var BalancerBucketInterface[] */
    protected array $buckets;

    protected ?string $seed;

    public function __construct(
        array $buckets,
        string $seed = null
    ) {
        $this->buckets = array_values($buckets);
        $this->seed = $seed;
    }

    public function addItem(): BalancerBucketInterface
    {
        $this->validateBuckets();

        $buckets = $this->selectMinCountBuckets();

        return $this->pickRandomBucket($buckets);
    }

    protected function validateBuckets(): void
    {
        if (!$this->buckets) {
            throw new LogicException('no buckets');
        }
    }

    /**
     * @param BalancerBucketInterface[] $buckets
     * @return BalancerBucketInterface
     */
    protected function pickRandomBucket(array $buckets): BalancerBucketInterface
    {
        if (!$buckets) {
            throw new LogicException('no minCountBuckets');
        }

        $bucket = $buckets[$this->random(count($buckets) - 1)];
        $bucket->addItem();

        return $bucket;
    }

    /**
     * @return BalancerBucketInterface[]
     */
    protected function selectMinCountBuckets(): array
    {
        $minCount = null;
        foreach ($this->buckets as $bucket) {
            $count = $bucket->countItems() * $bucket->getWeight();
            if ($minCount === null || $count <= $minCount) {
                $minCount = $count;
            }
        }
        $minCount += 0.00001; // to fix float

        $minCountBuckets = [];
        foreach ($this->buckets as $bucket) {
            if ($bucket->countItems() * $bucket->getWeight() <= $minCount) {
                $minCountBuckets[] = $bucket;
            }
        }

        return $minCountBuckets;
    }

    protected function random(int $max): int
    {
        $random = null;
        if ($this->seed === null) {
            try {
                $random = random_int(0, $max);
            } catch (Throwable) {
            }
        }

        if ($random === null) {
            $seed = $this->getRandomSeed();
            $random = abs(crc32(md5($seed))) % ($max + 1);
        }

        return $random;
    }

    private function getRandomSeed(): string
    {
        $seed = $this->seed;
        foreach ($this->buckets as $bucket) {
            $seed .= $bucket->getName() . $bucket->countItems();
        }

        return $seed;
    }
}

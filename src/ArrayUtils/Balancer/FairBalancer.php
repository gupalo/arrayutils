<?php

namespace Gupalo\ArrayUtils\Balancer;

use LogicException;
use Throwable;

class FairBalancer implements BalancerInterface
{
    /** @var BucketInterface[] */
    protected array $buckets;

    protected string $seed;

    public function __construct(
        array $buckets,
        string $seed = ''
    ) {
        $this->buckets = array_values($buckets);
        $this->seed = $seed;
        $this->validateBuckets();
    }

    public function chooseBucket(): BucketInterface
    {
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
     * @param BucketInterface[] $buckets
     * @return BucketInterface
     */
    protected function pickRandomBucket(array $buckets): BucketInterface
    {
        if (!$buckets) {
            throw new LogicException('no minCountBuckets');
        }

        $bucket = $buckets[$this->random(count($buckets) - 1)];
        $bucket->addItem();

        return $bucket;
    }

    /**
     * @return BucketInterface[]
     */
    protected function selectMinCountBuckets(): array
    {
        $buckets = $this->buckets;
        // sort DESC
        usort(
            $buckets,
            static fn (BucketInterface $a, BucketInterface $b): int => $a->getScore() <=> $b->getScore()
        );
        $minScore = $buckets[0]->getScore();

        return array_filter($buckets, static fn (BucketInterface $bucket): bool => $bucket->getScore() <= $minScore);
    }

    protected function random(int $max): int
    {
        $random = null;
        if (!$this->seed) {
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
            $seed .= $bucket->getName() . $bucket->getCount();
        }

        return $seed;
    }
}

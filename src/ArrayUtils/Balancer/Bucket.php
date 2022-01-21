<?php

namespace Gupalo\ArrayUtils\Balancer;

class Bucket implements BucketInterface
{
    public function __construct(
        private string $name,
        private float $weight = 1.0,
        private int $countItems = 0,
    ) {
        $this->validate();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getCount(): int
    {
        return $this->countItems;
    }

    public function getScore(): float
    {
        return $this->weight * $this->countItems;
    }

    public function addItem(): void
    {
        $this->countItems++;
    }

    private function validate(): void
    {
        if ($this->weight < 0) {
            throw new \InvalidArgumentException('weight should be 0 or more');
        }
        if ($this->countItems < 0) {
            throw new \InvalidArgumentException('countItems should be 0 or more');
        }
    }

}

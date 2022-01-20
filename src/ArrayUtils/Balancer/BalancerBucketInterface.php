<?php

namespace Gupalo\ArrayUtils\Balancer;

interface BalancerBucketInterface
{
    public function getName(): string;

    public function getWeight(): float;

    public function countItems(): int;

    public function addItem(): void;
}

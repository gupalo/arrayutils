<?php

namespace Gupalo\ArrayUtils\Balancer;

interface BucketInterface
{
    public function getName(): string;

    public function getWeight(): float;

    public function getCount(): int;

    public function getScore(): float;

    public function addItem(): void;
}

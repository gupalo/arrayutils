<?php

namespace Gupalo\ArrayUtils\Balancer;

interface BalancerInterface
{
    public function addItem(): BalancerBucketInterface;
}

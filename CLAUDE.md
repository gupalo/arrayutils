# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Build Commands

```bash
# Install dependencies
composer install

# Run all tests
./vendor/bin/phpunit

# Run a single test file
./vendor/bin/phpunit tests/ArrayUtils/ArrayRandomTest.php

# Run a specific test method
./vendor/bin/phpunit --filter testPickMultiple

# Run static analysis
./vendor/bin/phpstan analyse -c phpstan.dist.neon
```

## Architecture

This is a PHP library providing static utility methods for array manipulation. All utility classes use static methods only.

**Namespace:** `Gupalo\ArrayUtils`

**Key Components:**
- **Array Utilities** (`src/ArrayUtils/`): Static helper classes for aggregation, comparison, filtering, indexing, and random selection
- **Balancer System** (`src/ArrayUtils/Balancer/`): Strategy pattern implementation for distributing items across buckets (e.g., A/B testing). `BalancerInterface` defines the contract, with `FairBalancer` (weighted distribution) and `SemiRandomBalancer` (seeded randomization) implementations

**Input Handling:** Most methods accept iterables (arrays, generators) of arrays or objects. Object property access uses Symfony PropertyAccessor, supporting public properties and getters.

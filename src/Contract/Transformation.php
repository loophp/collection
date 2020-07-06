<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 */
interface Transformation
{
    /**
     * @param iterable<TKey, T> $collection
     *
     * @return iterable<TKey, T>|U
     */
    public function __invoke(iterable $collection);
}

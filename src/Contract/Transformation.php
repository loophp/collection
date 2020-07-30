<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Transformation
{
    /**
     * @param iterable<mixed> $collection
     * @psalm-param iterable<TKey, T> $collection
     *
     * @return mixed
     * @psalm-return T|scalar|\Iterator<TKey, T>|array<TKey, T>|null
     */
    public function __invoke(iterable $collection);
}

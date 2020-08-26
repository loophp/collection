<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Transformation
{
    /**
     * @psalm-param \Iterator<TKey, T> $collection
     *
     * @return mixed
     * @psalm-return T|scalar|\Iterator<TKey, T>|array<TKey, T>|null
     */
    public function __invoke();
}

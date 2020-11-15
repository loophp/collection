<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Zipable
{
    /**
     * Zip a collection together with one or more iterables.
     *
     * @param iterable<mixed> ...$iterables
     *
     * @psalm-return \loophp\collection\Collection<TKey,T>
     */
    public function zip(iterable ...$iterables): Collection;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Zipable
{
    /**
     * Zip a collection together with one or more iterables.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#zip
     *
     * @template U
     * @template UKey
     *
     * @param iterable<UKey, U> ...$iterables
     *
     * @return Collection<list<TKey|UKey>, list<T|U>>
     */
    public function zip(iterable ...$iterables): Collection;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Closure;

interface Sameable
{
    /**
     * Compare two collections for sameness. Collections are considered same if:
     * - they have the same number of elements;
     * - they have the same keys and elements, in the same order.
     *
     * By default elements and keys will be compared using strict equality (`===`). However, this behaviour
     * can be customized with a comparator callback. This should be a curried function which takes
     * first the left value and key, then the right value and key, and returns a boolean.
     *
     * This operation will stop and return a value as soon as one of the collections has been seen fully
     * or as soon as the comparison yields false for any key-value pair.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#same
     *
     * @param iterable<mixed, mixed> $other
     * @param null|callable(mixed, mixed): (Closure(mixed, mixed): bool) $comparatorCallback
     */
    public function same(iterable $other, ?callable $comparatorCallback = null): bool;
}

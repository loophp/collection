<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

interface Equalsable
{
    /**
     * Compare two collections for equality. Collections are considered equal if:
     * - they have the same number of elements;
     * - they contain the same elements, regardless of the order they appear in or their keys.
     *
     * Elements will be compared using strict equality (`===`). If you want to customize how
     * elements are compared or the order in which the keys/values appear is important, use the `same` operation.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#equals
     *
     * @param iterable<mixed, mixed> $other
     */
    public function equals(iterable $other): bool;
}

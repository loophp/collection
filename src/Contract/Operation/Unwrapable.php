<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Unwrapable
{
    /**
     * Opposite of `wrap`, turn a collection of arrays into a flat list.
     * Equivalent to `flatten(1)`.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#unwrap
     *
     * @return Collection<mixed, mixed>
     */
    public function unwrap(): Collection;
}

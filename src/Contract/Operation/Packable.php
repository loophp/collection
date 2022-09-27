<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Packable
{
    /**
     * Wrap each item into an array containing 2 items: the key and the value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#pack
     *
     * @return Collection<int, array{0: TKey, 1: T}>
     */
    public function pack(): Collection;
}

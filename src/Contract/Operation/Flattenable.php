<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

use const PHP_INT_MAX;

/**
 * @template TKey
 * @template T
 */
interface Flattenable
{
    /**
     * Flatten a collection of items into a simple flat collection.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#flatten
     *
     * @return Collection<mixed, mixed>
     */
    public function flatten(int $depth = PHP_INT_MAX): Collection;
}

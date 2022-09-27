<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Untilable
{
    /**
     * Iterate over the collection items until the provided callback(s) are satisfied.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#until
     *
     * @param callable(T, TKey):bool ...$callbacks
     *
     * @return Collection<TKey, T>
     */
    public function until(callable ...$callbacks): Collection;
}

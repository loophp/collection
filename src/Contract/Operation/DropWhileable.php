<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface DropWhileable
{
    /**
     * Iterate over the collection items and takes from it its elements
     * from the moment when the condition fails for the first time till the end of the list.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#dropwhile
     *
     * @return Collection<TKey, T>
     */
    public function dropWhile(callable ...$callbacks): Collection;
}

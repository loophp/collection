<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Headable
{
    /**
     * Get the first item from the collection.
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function head(): Collection;
}

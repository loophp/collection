<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Flipable
{
    /**
     * Flip keys and items in a collection.
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function flip(): Collection;
}

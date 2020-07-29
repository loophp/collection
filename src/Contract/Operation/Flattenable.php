<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

use const PHP_INT_MAX;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Flattenable
{
    /**
     * Flatten a collection of items into a simple flat collection.
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public function flatten(int $depth = PHP_INT_MAX): Base;
}

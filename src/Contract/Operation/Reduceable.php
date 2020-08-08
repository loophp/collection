<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Reduceable
{
    /**
     * Reduce the collection to a single value.
     *
     * @param mixed $initial
     * @psalm-param T|null $initial
     *
     * @return mixed
     * @psalm-return T|null
     */
    public function reduce(callable $callback, $initial = null);
}

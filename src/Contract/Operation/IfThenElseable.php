<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface IfThenElseable
{
    /**
     * Execute a mapping callback on each item of the collection when a condition is met.
     * If no `else` callback is provided, the identity function is applied (elements are not modified).
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#ifthenelse
     *
     * @return Collection<TKey, T>
     */
    public function ifThenElse(callable $condition, callable $then, ?callable $else = null): Collection;
}

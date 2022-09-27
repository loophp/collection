<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface AsyncMapNable
{
    /**
     * Asynchronously apply one or more supplied callbacks to every item of a collection and use the return value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#asyncmapn
     *
     * @param callable(mixed, mixed): mixed ...$callbacks
     *
     * @return Collection<mixed, mixed>
     */
    public function asyncMapN(callable ...$callbacks): Collection;
}

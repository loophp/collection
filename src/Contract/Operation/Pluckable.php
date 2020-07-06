<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template U
 * @template V
 */
interface Pluckable
{
    /**
     * Retrieves all of the values of a collection for a given key.
     *
     * @param U $pluck
     * @param V $default
     *
     * @return Collection<int, T>
     */
    public function pluck($pluck, $default = null): Collection;
}

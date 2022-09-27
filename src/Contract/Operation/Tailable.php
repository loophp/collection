<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Tailable
{
    /**
     * Get the collection items except the first.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#tail
     *
     * @return Collection<TKey, T>
     */
    public function tail(): Collection;
}

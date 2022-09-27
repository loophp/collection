<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Initable
{
    /**
     * Returns the collection without its last item.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#init
     *
     * @return Collection<TKey, T>
     */
    public function init(): Collection;
}

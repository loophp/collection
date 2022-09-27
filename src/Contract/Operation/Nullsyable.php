<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Nullsyable
{
    /**
     * Check if the collection contains only *nullsy* values.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#nullsy
     */
    public function nullsy(): bool;
}

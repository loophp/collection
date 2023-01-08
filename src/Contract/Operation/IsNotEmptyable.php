<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface IsNotEmptyable
{
    /**
     * Check if a collection has at least one element inside.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#isnotempty
     */
    public function isNotEmpty(): bool;
}

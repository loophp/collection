<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Allable
{
    /**
     * Get all items from the collection.
     *
     * @return array<TKey, T>
     *   An array containing all the elements of the collection.
     */
    public function all(): array;
}

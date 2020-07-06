<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * Interface Allable.
 *
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Allable
{
    /**
     * Get all items from the collection.
     *
     * @return array<mixed>
     *   An array containing all the elements of the collection.
     */
    public function all(): array;
}

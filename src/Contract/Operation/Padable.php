<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 * @template TKey
 * @psalm-template TKey of array-key
 * @template U
 */
interface Padable
{
    /**
     * Pad a collection to the given length with a given value.
     *
     * @param U $value
     *
     * @return Collection<int|TKey, T|U>
     */
    public function pad(int $size, $value): Collection;
}

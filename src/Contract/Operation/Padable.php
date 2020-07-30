<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Padable
{
    /**
     * Pad a collection to the given length with a given value.
     *
     * @param mixed $value
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function pad(int $size, $value): Collection;
}

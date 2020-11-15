<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Splitable
{
    public const AFTER = 1;

    public const BEFORE = -1;

    public const REMOVE = 0;

    /**
     * Split a collection using a callback.
     *
     * @param callable ...$callbacks
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function split(int $type = Splitable::BEFORE, callable ...$callbacks): Collection;
}

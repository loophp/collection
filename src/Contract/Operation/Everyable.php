<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T of bool
 */
interface Everyable
{
    /**
     * @psalm-return \loophp\collection\Contract\Collection<TKey, bool>
     */
    public function every(callable $callback): Collection;
}

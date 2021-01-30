<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Associateable
{
    /**
     * @psalm-param null|callable(TKey, TKey, T, Iterator<TKey, T>):TKey $callbackForKeys
     * @psalm-param null|callable(T, TKey, T, Iterator<TKey, T>):T $callbackForValues
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function associate(?callable $callbackForKeys = null, ?callable $callbackForValues = null): Collection;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Associateable
{
    /**
     * @psalm-param null|callable(TKey, T):(TKey) $callbackForKeys
     * @psalm-param null|callable(TKey, T):(T) $callbackForValues
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function associate(?callable $callbackForKeys = null, ?callable $callbackForValues = null): Collection;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Getable
{
    /**
     * Get an item by key.
     *
     * @param int|string $key
     * @psalm-param TKey $key
     *
     * @param mixed $default
     * @psalm-param T|null $default
     *
     * @psalm-return \loophp\collection\Contract\Collection<TKey, T|null>
     */
    public function get($key, $default = null): Collection;
}

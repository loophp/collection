<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Tailable
{
    /**
     * Get last collection items of a collection.
     *
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function tail(?int $length = null): Collection;
}

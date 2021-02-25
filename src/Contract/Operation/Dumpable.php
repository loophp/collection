<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Closure;
use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Dumpable
{
    /**
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): Collection;
}

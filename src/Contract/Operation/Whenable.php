<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Whenable
{
    /**
     * @param callable(Iterator<TKey, T>): bool $predicate
     * @param callable(Iterator<TKey, T>): iterable<TKey, T> $whenTrue
     * @param callable(Iterator<TKey, T>): iterable<TKey, T> $whenFalse
     *
     * @return Collection<TKey, T>
     */
    public function when(callable $predicate, callable $whenTrue, ?callable $whenFalse = null): Collection;
}

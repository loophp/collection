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
interface FoldRightable
{
    /**
     * Takes the initial value and the last item of the list and applies the function, then it takes
     * the penultimate item from the end and the result, and so on. See scanRight for intermediate results.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#foldright
     *
     * @param callable(T, T, TKey, Iterator<TKey, T>): T $callback
     * @param T|null $initial
     *
     * @return Collection<TKey, T|null>
     */
    public function foldRight(callable $callback, $initial = null): Collection;
}

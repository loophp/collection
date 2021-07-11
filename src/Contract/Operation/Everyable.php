<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;

/**
 * @template TKey
 * @template T
 */
interface Everyable
{
    /**
     * @param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
     */
    public function every(callable ...$callbacks): bool;
}

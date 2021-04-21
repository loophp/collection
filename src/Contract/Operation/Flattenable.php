<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

use const PHP_INT_MAX;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Flattenable
{
    /**
     * Flatten a collection of items into a simple flat collection.
     *
     * @psalm-return \loophp\collection\Collection<TKey, T>
     */
    public function flatten(int $depth = PHP_INT_MAX): Collection;
}

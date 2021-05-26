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
 * @template TKey of array-key
 * @template T
 */
interface Associateable
{
    /**
     * @template U of array-key
     *
     * @param null|callable(TKey, TKey, T, Iterator<TKey, T>): U $callbackForKeys
     * @param null|callable(T, TKey, T, Iterator<TKey, T>): mixed $callbackForValues
     *
     * @return \loophp\collection\Collection<TKey|U, mixed|T>
     */
    public function associate(?callable $callbackForKeys = null, ?callable $callbackForValues = null): Collection;
}

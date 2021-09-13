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
interface Associateable
{
    /**
     * Transform keys and values of the collection independently and combine them.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#associate
     *
     * @template NewT
     * @template NewTKey
     *
     * @param callable(TKey=, T=, Iterator<TKey, T>=): NewTKey $callbackForKeys
     * @param callable(T=, TKey=, Iterator<TKey, T>=): NewT $callbackForValues
     *
     * @return Collection<NewTKey, NewT>
     */
    public function associate(?callable $callbackForKeys = null, ?callable $callbackForValues = null): Collection;
}

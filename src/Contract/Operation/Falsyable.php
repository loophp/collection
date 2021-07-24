<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Falsyable
{
    /**
     * Check if the collection contains only falsy values.
     * A value is determined to be falsy by applying a `bool` cast.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#falsy
     */
    public function falsy(): bool;
}

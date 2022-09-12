<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Firstable
{
    /**
     * Get the first item from the collection in a separate collection. Alias for `head`.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#first
     *
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function first($default = null);
}

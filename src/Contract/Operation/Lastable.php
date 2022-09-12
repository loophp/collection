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
interface Lastable
{
    /**
     * Extract the last element of a collection, which must be finite and non-empty.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#last
     *
     * @template V
     *
     * @param V $default
     *
     * @return T|V
     */
    public function last($default = null);
}

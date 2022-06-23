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
interface Minable
{
    /**
     * Generate the minimum value of the collection by successively applying the PHP `min` function
     * to each pair of two elements.
     *
     * If custom logic is required to determine the minimum, such as when comparing objects,
     * the `compare` operation can be used instead.
     *
     * @see https://www.php.net/manual/en/function.min.php
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#min
     *
     * @return Collection<TKey, T>
     */
    public function min(): Collection;
}

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
interface Zipable
{
    /**
     * Zip a collection together with one or more iterables.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#zip
     *
     * @param iterable<mixed, mixed> ...$iterables
     *
     * @return Collection<list<mixed|TKey>, list<mixed|T>>
     */
    public function zip(iterable ...$iterables): Collection;
}

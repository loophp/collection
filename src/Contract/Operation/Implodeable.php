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
interface Implodeable
{
    /**
     * Join all the elements of the collection into a single string
     * using a glue provided or the empty string as default.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#implode
     *
     * @return Collection<TKey, string>
     */
    public function implode(string $glue = ''): Collection;
}

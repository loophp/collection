<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Closure;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Dumpable
{
    /**
     * Dump one or multiple items. It uses symfony/var-dumper if it is available,
     * var_dump() otherwise. A custom `callback` can be also used.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#dump
     *
     * @return Collection<TKey, T>
     */
    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): Collection;
}

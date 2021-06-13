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
     * @return Collection<TKey, T>
     */
    public function dump(string $name = '', int $size = 1, ?Closure $closure = null): Collection;
}

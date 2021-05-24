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
interface Pairable
{
    /**
     * @return \loophp\collection\Collection<T|TKey, T>
     */
    public function pair(): Collection;
}

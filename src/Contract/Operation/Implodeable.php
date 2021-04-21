<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Implodeable
{
    /**
     * @psalm-return \loophp\collection\Collection<int, string>
     */
    public function implode(string $glue = ''): Collection;
}

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
interface Padable
{
    /**
     * Pad a collection to the given length with a given value.
     *
     * @param mixed $value
     *
     * @psalm-return \loophp\collection\Collection<int|TKey, T>
     */
    public function pad(int $size, $value): Collection;
}

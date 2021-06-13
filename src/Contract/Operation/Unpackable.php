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
 * @template T of array{0: NewTKey, 1: NewT}
 *
 * @template NewTKey
 * @template NewT
 */
interface Unpackable
{
    /**
     * @return Collection<NewTKey, NewT>
     */
    public function unpack(): Collection;
}

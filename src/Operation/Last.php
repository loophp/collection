<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Last implements Operation
{
    /**
     * @pure
     *
     * @param Iterator<TKey, T> $iterator
     *
     * @return Generator<TKey, T>
     */
    public function __invoke(Iterator $iterator): Generator
    {
        $isEmpty = true;

        foreach ($iterator as $key => $current) {
            $isEmpty = false;
        }

        if (false === $isEmpty) {
            /**
             * @var TKey $key
             * @var T $current
             */
            return yield $key => $current;
        }
    }
}

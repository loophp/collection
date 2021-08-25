<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Tails implements Operation
{
    /**
     * @pure
     *
     * @param Iterator<TKey, T> $iterator
     *
     * @return Generator<int, list<T>, mixed, void>
     */
    public function __invoke(Iterator $iterator): Generator
    {
        $iterator = (new Pack())()($iterator);
        $data = [...$iterator];

        while ([] !== $data) {
            $unpack = (new Unpack())()(new ArrayIterator($data));

            yield [...$unpack];

            array_shift($data);
        }

        return yield [];
    }
}

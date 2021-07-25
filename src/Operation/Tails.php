<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Tails extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, list<T>, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, list<T>, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                /** @var Iterator<int, array{0: TKey, 1: T}> $iterator */
                $iterator = Pack::of()($iterator);
                $data = [...$iterator];

                while ([] !== $data) {
                    /** @var Iterator<TKey, T> $unpack */
                    $unpack = Unpack::of()(new ArrayIterator($data));

                    yield [...$unpack];

                    array_shift($data);
                }

                return yield [];
            };
    }
}

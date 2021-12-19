<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\iterators\PackIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Pack extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, array{0: TKey, 1: T}>
             */
            static function (Iterator $iterator): Generator {
                /** @var PackIterableAggregate<TKey, T> $packIterableAggregate */
                $packIterableAggregate = new PackIterableAggregate($iterator);

                return yield from $packIterableAggregate->getIterator();
            };
    }
}

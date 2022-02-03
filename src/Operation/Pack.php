<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
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
     * @return Closure(iterable<TKey, T>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<int, array{0: TKey, 1: T}>
             */
            static function (iterable $iterable): Generator {
                /** @var PackIterableAggregate<TKey, T> $iterable */
                $iterable = new PackIterableAggregate($iterable);

                yield from $iterable->getIterator();
            };
    }
}

<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use AppendIterator;
use ArrayIterator;
use Closure;
use Generator;
use InfiniteIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Intersperse extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(T): Closure(int): Closure(int): Closure(iterable<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T $element
             *
             * @return Closure(int): Closure(int): Closure(iterable<TKey, T>): Generator<int|TKey, T>
             */
            static fn ($element): Closure =>
                /**
                 * @return Closure(int): Closure(iterable<TKey, T>): Generator<int|TKey, T>
                 */
                static fn (int $atEvery): Closure =>
                    /**
                     * @return Closure(iterable<TKey, T>): Generator<int|TKey, T>
                     */
                    static fn (int $startAt): Closure =>
                        /**
                         * @param iterable<TKey, T> $iterable
                         *
                         * @return Generator<int|TKey, T>
                         */
                        static function (iterable $iterable) use ($element, $atEvery, $startAt): Generator {
                            $intersperse = new AppendIterator();
                            $intersperse->append(
                                new ArrayIterator(array_fill(0, $startAt, 1))
                            );
                            $intersperse->append(
                                new InfiniteIterator(new ArrayIterator(range(0, $atEvery - 1)))
                            );
                            $intersperse->rewind();

                            foreach ($iterable as $key => $value) {
                                if (0 === $intersperse->current()) {
                                    yield $element;
                                }

                                yield $key => $value;

                                $intersperse->next();
                            }
                        };
    }
}

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
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Zip extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(iterable<TKey, T>...): Closure(Iterator<TKey, T>): Iterator<list<TKey>, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> ...$iterables
             *
             * @return Closure(Iterator<TKey, T>): Iterator<list<TKey>, list<T>>
             */
            static function (iterable ...$iterables): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<list<TKey>, list<T>> $pipe */
                $pipe = Pipe::of()(
                    (
                    /**
                     * @param list<iterable<TKey, T>> $iterables
                     */
                    static fn (array $iterables): Closure =>
                    /**
                     * @param Iterator<TKey, T> $iterator
                     */
                    static fn (Iterator $iterator): Iterator => new ArrayIterator([$iterator, ...$iterables])
                    )($iterables),
                    Reduce::of()(
                        static function (MultipleIterator $acc, iterable $iterable): MultipleIterator {
                            $acc->attachIterator(new IterableIterator($iterable));

                            return $acc;
                        }
                    )(new MultipleIterator(MultipleIterator::MIT_NEED_ANY)),
                    ((new Flatten())()(1))
                );

                // Point free style.
                return $pipe;
            };
    }
}

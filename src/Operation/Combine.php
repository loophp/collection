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
use loophp\iterators\MultipleIterableAggregate;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Combine extends AbstractOperation
{
    /**
     * @pure
     *
     * @template U
     *
     * @return Closure(U...): Closure(Iterator<TKey, T>): Generator<null|U, null|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param U ...$keys
             *
             * @return Closure(Iterator<TKey, T>): Generator<null|U, null|T>
             */
            static function (...$keys): Closure {
                $buildMultipleIterable =
                    /**
                     * @param array<array-key, U> $keys
                     */
                    static fn (array $keys): Closure =>
                        /**
                         * @param Iterator<TKey, T> $iterator
                         *
                         * @return iterable
                         */
                        static fn (Iterator $iterator): iterable => yield from new MultipleIterableAggregate([$keys, $iterator], MultipleIterator::MIT_NEED_ANY);

                /** @var Closure(Iterator<TKey, T>): Generator<null|U, null|T> $pipe */
                $pipe = Pipe::of()(
                    $buildMultipleIterable($keys),
                    Flatten::of()(1),
                    Pair::of(),
                );

                // Point free style.
                return $pipe;
            };
    }
}

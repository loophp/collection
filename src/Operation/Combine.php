<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
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
     * @return Closure(U...): Closure(iterable<TKey, T>): Generator<null|U, null|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param U ...$keys
             *
             * @return Closure(iterable<TKey, T>): Generator<null|U, null|T>
             */
            static function (...$keys): Closure {
                $buildMultipleIterable =
                    /**
                     * @param array<array-key, U> $keys
                     */
                    static fn (array $keys): Closure =>
                        /**
                         * @param iterable<TKey, T> $iterable
                         *
                         * @return Generator
                         */
                        static fn (iterable $iterable): Generator => yield from new MultipleIterableAggregate([$keys, $iterable], MultipleIterator::MIT_NEED_ANY);

                /** @var Closure(iterable<TKey, T>): Generator<null|U, null|T> $pipe */
                $pipe = (new Pipe())()(
                    $buildMultipleIterable($keys),
                    (new Flatten())()(1),
                    (new Pair())(),
                );

                // Point free style.
                return $pipe;
            };
    }
}

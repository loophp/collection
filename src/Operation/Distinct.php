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

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Distinct extends AbstractOperation
{
    /**
     * @template U
     *
     * @return Closure(callable(U): Closure(U): bool): Closure(callable(T, TKey): U): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(U): (Closure(U): bool) $comparatorCallback
             *
             * @return Closure(callable(T, TKey): U): Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $comparatorCallback): Closure =>
                /**
                 * @param callable(T, TKey): U $accessorCallback
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, T>
                 */
                static function (callable $accessorCallback) use ($comparatorCallback): Closure {
                    /** @var ArrayIterator<int, array{0: TKey, 1: T}> $stack */
                    $stack = new ArrayIterator();

                    $filter = (new Filter())()(
                        /**
                         * @param T $value
                         * @param TKey $key
                         */
                        static function ($value, $key) use ($comparatorCallback, $accessorCallback, $stack): bool {
                            $every = (new Every())()(
                                /**
                                 * @param array{0: TKey, 1: T} $keyValuePair
                                 */
                                static fn (int $index, array $keyValuePair): bool => !$comparatorCallback($accessorCallback($value, $key))($accessorCallback($keyValuePair[1], $keyValuePair[0]))
                            )($stack);

                            if (false === $every->current()) {
                                return false;
                            }

                            $stack->append([$key, $value]);

                            return true;
                        }
                    );

                    // Point free style.
                    return $filter;
                };
    }
}

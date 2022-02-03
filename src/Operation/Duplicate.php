<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

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
final class Duplicate extends AbstractOperation
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
                    /** @var array<int, array{0: TKey, 1: T}> $stack */
                    $stack = [];

                    $filter = (new Filter())()(
                        /**
                         * @param T $value
                         * @param TKey $key
                         */
                        static function ($value, $key) use ($comparatorCallback, $accessorCallback, &$stack): bool {
                            $matchWhenNot = static fn (): bool => true;
                            $matcher =
                                /**
                                 * @param array{0: TKey, 1: T} $item
                                 */
                                static fn (array $item): bool => $comparatorCallback($accessorCallback($value, $key))($accessorCallback($item[1], $item[0]));

                            $matchFalse = (new MatchOne())()($matchWhenNot)($matcher)($stack);

                            if ($matchFalse->current()) {
                                return true;
                            }

                            $stack[] = [$key, $value];

                            return false;
                        }
                    );

                    // Point free style.
                    return $filter;
                };
    }
}

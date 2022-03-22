<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Utils\CallbacksArrayReducer;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Every extends AbstractOperation
{
    /**
     * @return Closure(callable(int=, T=, TKey=, iterable<TKey, T>=): bool): Closure(callable(bool, int, T, TKey, iterable<TKey, T>...): mixed): Closure(iterable<TKey, T>): Generator<int, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(int=, T=, TKey=, iterable<TKey, T>=): bool $predicate
             *
             * @return Closure(callable(bool, int, T=, TKey=, iterable<TKey, T>=): mixed): Closure(iterable<TKey, T>): Generator<int, mixed>
             */
            static function (callable ...$predicates): Closure {
                return
                    /**
                     * @param callable(bool, int, T=, TKey=, iterable<TKey, T>=): mixed $return
                     *
                     * @return Closure(iterable<TKey, T>): Generator<int, mixed>
                     */
                    static function (callable $return) use ($predicates): Closure {
                        return
                            /**
                             * @param iterable<TKey, T> $iterable
                             *
                             * @return Generator<int, mixed>
                             */
                            static function (iterable $iterable) use ($return, $predicates): Generator {
                                $predicate = CallbacksArrayReducer::or()($predicates);

                                foreach ((new Pack())()($iterable) as $index => [$key, $value]) {
                                    if (false === $predicate($index, $value, $key, $iterable)) {
                                        return yield $return(false, $index, $value, $key, $iterable);
                                    }
                                }

                                return yield true;
                            };
                    };
            };
    }
}

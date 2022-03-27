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
     * @return Closure(...callable(int=, T=, TKey=, iterable<TKey, T>=): bool): Closure(iterable<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(int=, T=, TKey=, iterable<TKey, T>=): bool ...$predicates
             *
             * @return Closure(iterable<TKey, T>): Generator<int, bool>
             */
            static function (callable ...$predicates): Closure {
                return
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return Generator<int, bool>
                     */
                    static function (iterable $iterable) use ($predicates): Generator {
                        $predicate = CallbacksArrayReducer::or()($predicates);

                        foreach ((new Pack())()($iterable) as $index => [$key, $value]) {
                            if (false === $predicate($index, $value, $key, $iterable)) {
                                return yield $index => false;
                            }
                        }

                        yield true;
                    };
            };
    }
}

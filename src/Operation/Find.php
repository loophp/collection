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
use loophp\collection\Utils\CallbacksArrayReducer;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 * @template V
 */
final class Find extends AbstractOperation
{
    /**
     * @pure
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param V        $valueIfPredicateIsNotMet
             * @param callable ...$predicates
             *
             * @return Closure(T, callable[]): Closure(Iterator<TKey, T>): Generator<T|V>
             */
            static function ($valueIfPredicateIsNotMet = null, callable ...$predicates): Closure {
                $findCallback = static function (
                    Iterator $iterator
                ) use ($valueIfPredicateIsNotMet, $predicates): Generator {
                    foreach ($iterator as $key => $current) {
                        if (CallbacksArrayReducer::or()($predicates, $current, $key, $iterator)) {
                            yield $current;
                        }
                    }

                    yield $valueIfPredicateIsNotMet;
                };

                $pipe = Pipe::of()(
                    $findCallback,
                    Head::of(),
                );

                // Point free style.
                return $pipe;
            };
    }
}

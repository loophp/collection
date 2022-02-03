<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation\Splitable;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Explode extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(T...): Closure(iterable<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$explodes
             *
             * @return Closure(iterable<TKey, T>): Generator<int, list<T>>
             */
            static function (...$explodes): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<int, list<T>> $split */
                $split = (new Split())()(Splitable::REMOVE)(
                    ...array_map(
                        /**
                         * @param T $explode
                         */
                        static fn ($explode): Closure =>
                            /**
                             * @param T $value
                             */
                            static fn ($value): bool => $value === $explode,
                        $explodes
                    )
                );

                // Point free style.
                return $split;
            };
    }
}

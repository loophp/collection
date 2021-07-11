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
use loophp\fpt\FPT;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class IntersectKeys extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(TKey...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param TKey ...$keys
             *
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (...$keys): Closure {
                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
                $filter = Filter::of()(
                    FPT::compose()(
                        FPT::partialLeft()(
                            'in_array'
                        )($keys, true),
                        FPT::arg()(1)
                    )
                );

                // Point free style.
                return $filter;
            };
    }
}

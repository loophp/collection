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
 */
final class Min extends AbstractOperation
{
    /**
     * @return Closure(null|callable(T, T): T): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param null|callable(T, T): T $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey,T>
             */
            static function (?callable $callback = null): Closure {
                $callback ??=
                    /**
                     * @param T $carry
                     * @param T $value
                     *
                     * @return T
                     */
                    static fn ($carry, $value) => min($value, $carry);

                /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $pipe */
                $pipe = (new Pipe())()(
                    (new FoldLeft1())()($callback),
                    (new Last())(),
                );

                // Point free style.
                return $pipe;
            };
    }
}

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
final class Compare extends AbstractOperation
{
    /**
     * @return Closure(callable(T, T): T): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, T): T $comparator
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey,T>
             */
            static function (callable $comparator): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $pipe */
                $pipe = (new Pipe())()(
                    (new FoldLeft1())()($comparator),
                    (new Last())(),
                );

                // Point free style.
                return $pipe;
            };
    }
}

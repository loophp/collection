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
final class Current extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(TKey): Closure(V): Closure(iterable<TKey, T>): Generator<int, T|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param TKey $index
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<int, T|V>
             */
            static fn (int $index): Closure =>
            /**
             * @param V $default
             *
             * @return Closure(iterable<TKey, T>): Generator<int, T|V>
             */
            static function ($default) use ($index): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<int, T|V> $pipe */
                $pipe = (new Pipe())()(
                    (new Normalize())(),
                    (new Get())()($index)($default)
                );

                // Point free style.
                return $pipe;
            };
    }
}

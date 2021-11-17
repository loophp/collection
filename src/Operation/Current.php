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

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Current extends AbstractOperation
{
    /**
     * @pure
     *
     * @template V
     *
     * @return Closure(TKey): Closure(V): Closure(Iterator<TKey, <|int, T|T>): Generator|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param TKey $index
             *
             * @return Closure(V): Closure(Iterator<TKey, <|int, T|T>): Generator|V>
             */
            static fn (int $index): Closure =>
            /**
             * @param V $default
             *
             * @return Closure(Iterator<TKey, <|int, T|T>): Generator|V>
             */
            static function ($default) use ($index): Closure {
                /** @var Closure(Iterator<TKey, <|int, T|T>): Generator|V> $pipe */
                $pipe = Pipe::of()(
                    (new Normalize())(),
                    Get::of()($index)($default)
                );

                // Point free style.
                return $pipe;
            };
    }
}

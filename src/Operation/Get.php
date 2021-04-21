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
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Get extends AbstractOperation
{
    /**
     * @psalm-return Closure((T | TKey)):Closure (T): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $keyToGet
             * @psalm-param T|TKey $keyToGet
             *
             * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
             */
            static fn ($keyToGet): Closure =>
                /**
                 * @param mixed $default
                 * @psalm-param T $default
                 *
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, T>
                 */
                static function ($default) use ($keyToGet): Closure {
                    $filterCallback =
                        /**
                         * @param mixed $value
                         * @psalm-param T $value
                         *
                         * @param mixed $key
                         * @psalm-param TKey $key
                         */
                        static fn ($value, $key): bool => $key === $keyToGet;

                    /** @psalm-var Closure(Iterator<TKey, T>):(Generator<int|TKey, T>) $pipe */
                    $pipe = Pipe::of()(
                        Filter::of()($filterCallback),
                        Append::of()($default),
                        Head::of()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}

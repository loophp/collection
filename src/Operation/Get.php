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
 * @template TKey of array-key
 * @template T
 */
final class Get extends AbstractOperation
{
    /**
     * @return Closure((T | TKey)):Closure (T): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T|TKey $keyToGet
             *
             * @return Closure(T): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
             */
            static fn ($keyToGet): Closure =>
                /**
                 * @param T $default
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<int|TKey, T>
                 */
                static function ($default) use ($keyToGet): Closure {
                    $filterCallback =
                        /**
                         * @param T $value
                         * @param TKey $key
                         */
                        static fn ($value, $key): bool => $key === $keyToGet;

                    /** @var Closure(Iterator<TKey, T>):(Generator<int|TKey, T>) $pipe */
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

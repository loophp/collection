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
final class Get extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(TKey): Closure(V): Closure(iterable<TKey, T>): Generator<TKey, T|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param TKey $keyToGet
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<TKey, T|V>
             */
            static fn ($keyToGet): Closure =>
                /**
                 * @param V $default
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, T|V>
                 */
                static function ($default) use ($keyToGet): Closure {
                    /** @var Closure(iterable<TKey, T>): (Generator<TKey, T|V>) $pipe */
                    $pipe = (new Pipe())()(
                        (new Filter())()(
                            /**
                             * @param T $value
                             * @param TKey $key
                             */
                            static fn ($value, $key): bool => $key === $keyToGet
                        ),
                        (new Append())()($default),
                        (new Head())()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}

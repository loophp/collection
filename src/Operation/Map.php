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
 * @psalm-template TKey of array-key
 * @psalm-template T
 * @psalm-template V
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Map extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): V ...): Closure(Iterator<TKey, V>): Generator<TKey, V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): V ...$callbacks
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, V>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $callbackFactory =
                        /**
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-return Closure(T, callable(T, TKey, Iterator<TKey, T>): V): V
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param mixed $carry
                             * @psalm-param T $carry
                             * @psalm-param callable(T, TKey, Iterator<TKey, T>): V $callback
                             *
                             * @psalm-return V
                             */
                            static fn ($carry, callable $callback) => $callback($carry, $key, $iterator);

                    foreach ($iterator as $key => $value) {
                        yield $key => array_reduce($callbacks, $callbackFactory($key), $value);
                    }
                };
    }
}

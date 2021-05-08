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
     * @psalm-return Closure(callable(T|V, TKey, Iterator<TKey, T>): V ...): Closure(Iterator<TKey, T>): Generator<TKey, T|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|V, TKey, Iterator<TKey, T>): V ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T|V>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T|V>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $callbackFactory =
                        /**
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-return Closure(T|V, callable(T|V, TKey, Iterator<TKey, T>): V): V
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param mixed $carry
                             * @psalm-param T|V $carry
                             * @psalm-param callable(T|V, TKey, Iterator<TKey, T>): V $callback
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

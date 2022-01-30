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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class MapN extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(mixed, mixed, iterable<TKey, T>): mixed ...): Closure(iterable<TKey, T>): Generator<mixed, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(mixed, mixed, iterable<TKey, T>): mixed ...$callbacks
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<mixed, mixed>
                 */
                static function (iterable $iterable) use ($callbacks): Generator {
                    $callbackFactory =
                        /**
                         * @param mixed $key
                         *
                         * @return Closure(mixed, callable(mixed, mixed, iterable<TKey, T>): mixed): mixed
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param mixed $carry
                             * @param callable(mixed, mixed, iterable<TKey, T>): mixed $callback
                             *
                             * @return mixed
                             */
                            static fn ($carry, callable $callback) => $callback($carry, $key, $iterable);

                    foreach ($iterable as $key => $value) {
                        yield $key => array_reduce($callbacks, $callbackFactory($key), $value);
                    }
                };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Map extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): T ...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): T ...$callbacks
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $callbackFactory =
                        /**
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-return Closure(T, callable(T, TKey, Iterator<TKey, T>): T): T
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param mixed $carry
                             * @psalm-param T $carry
                             * @psalm-param callable(T, TKey, Iterator<TKey, T>): T $callback
                             *
                             * @psalm-return T
                             */
                            static fn ($carry, callable $callback) => $callback($carry, $key, $iterator);

                    foreach ($iterator as $key => $value) {
                        yield $key => array_reduce($callbacks, $callbackFactory($key), $value);
                    }
                };
    }
}

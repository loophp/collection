<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CallbackFilterIterator;
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
final class Filter extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T , TKey , Iterator<TKey, T> ): bool ...):Closure (Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $defaultCallback =
                        /**
                         * @param mixed $value
                         * @psalm-param T $value
                         *
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-param Iterator<TKey, T> $iterator
                         */
                        static fn ($value, $key, Iterator $iterator): bool => (bool) $value;

                    $callbacks = [] === $callbacks ?
                        [$defaultCallback] :
                        $callbacks;

                    return yield from array_reduce(
                        $callbacks,
                        static fn (Iterator $carry, callable $callback): CallbackFilterIterator => new CallbackFilterIterator($carry, $callback),
                        $iterator
                    );
                };
    }
}

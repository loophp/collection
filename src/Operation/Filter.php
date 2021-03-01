<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CallbackFilterIterator;
use Closure;
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
     * @psalm-return Closure(callable(T , TKey, Iterator<TKey, T>): bool ...): Closure (Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Iterator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callbacks): Iterator {
                    $defaultCallback =
                        /**
                         * @param mixed $value
                         * @psalm-param T $value
                         */
                        static fn ($value): bool => (bool) $value;

                    $callbacks = [] === $callbacks ?
                        [$defaultCallback] :
                        $callbacks;

                    return array_reduce(
                        $callbacks,
                        static fn (Iterator $carry, callable $callback): CallbackFilterIterator => new CallbackFilterIterator($carry, $callback),
                        $iterator
                    );
                };
    }
}

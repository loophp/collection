<?php

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
final class Associate extends AbstractOperation
{
    /**
     * @template NewTKey
     * @template NewT
     *
     * @return Closure(callable(mixed=, mixed=, iterable<mixed, mixed>=): mixed): Closure(callable(mixed=, mixed=, iterable<mixed, mixed>=): mixed): Closure(iterable<mixed, mixed>): Generator<mixed, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(TKey=, T=, iterable<TKey, T>=): NewTKey $callbackForKeys
             *
             * @return Closure((callable(T=, TKey=, iterable<TKey, T>=): NewT)): Closure(iterable<TKey, T>): Generator<NewTKey, NewT>
             */
            static fn (callable $callbackForKeys): Closure =>
                /**
                 * @param callable(T=, TKey=, iterable<TKey, T>=): NewT $callbackForValues
                 *
                 * @return Closure(iterable<TKey, T>): Generator<NewTKey, NewT>
                 */
                static fn (callable $callbackForValues): Closure =>
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return Generator<NewTKey, NewT>
                     */
                    static function (iterable $iterable) use ($callbackForKeys, $callbackForValues): Generator {
                        foreach ($iterable as $key => $value) {
                            yield $callbackForKeys($key, $value, $iterable) => $callbackForValues($value, $key, $iterable);
                        }
                    };
    }
}

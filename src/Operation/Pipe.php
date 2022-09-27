<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Pipe extends AbstractOperation
{
    /**
     * @return Closure(callable(iterable<TKey, T>): iterable<TKey, T> ...): Closure(iterable<TKey, T>): iterable<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(iterable<TKey, T>): iterable<TKey, T> ...$operations
             *
             * @return Closure(iterable<TKey, T>): iterable<TKey, T>
             */
            static fn (callable ...$operations): Closure => array_reduce(
                $operations,
                /**
                 * @param callable(iterable<TKey, T>): iterable<TKey, T> $f
                 * @param callable(iterable<TKey, T>): iterable<TKey, T> $g
                 *
                 * @return Closure(iterable<TKey, T>): iterable<TKey, T>
                 */
                static fn (callable $f, callable $g): Closure =>
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return iterable<TKey, T>
                     */
                    static fn (iterable $iterable): iterable => $g($f($iterable)),
                static fn (iterable $iterable): iterable => $iterable
            );
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;
use loophp\iterators\TypedIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Strict extends AbstractOperation
{
    /**
     * @return Closure(null|callable(mixed): string): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param null|callable(mixed): string $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (?callable $callback = null): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, T>
                 */
                static fn (iterable $iterator): Generator => yield from new TypedIterableAggregate((new IterableIteratorAggregate($iterator))->getIterator(), $callback);
    }
}

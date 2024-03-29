<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\MultipleIterableAggregate;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Transpose extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        $callbackForKeys =
            /**
             * @param non-empty-array<int, TKey> $key
             *
             * @return TKey
             */
            static fn (array $key): mixed => reset($key);

        $callbackForValues =
            /**
             * @param array<int, T> $value
             *
             * @return array<int, T>
             */
            static fn (array $value): array => $value;

        /** @var Closure(iterable<TKey, T>): Generator<TKey, list<T>> $pipe */
        $pipe = (new Pipe())()(
            static fn (iterable $iterables): MultipleIterableAggregate => new MultipleIterableAggregate($iterables, MultipleIterator::MIT_NEED_ANY),
            (new Associate())()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}

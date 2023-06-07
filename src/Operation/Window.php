<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\LimitIterableAggregate;
use loophp\iterators\ReductionIterableAggregate;

use function array_slice;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Window extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(iterable<TKey, T>): Generator<TKey|int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<TKey|int, list<T>>
             */
            static fn (int $size): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey|int, list<T>>
                 */
                static fn (iterable $iterable): Generator => yield from new LimitIterableAggregate(new ReductionIterableAggregate(
                    $iterable,
                    /**
                     * @param list<T> $stack
                     * @param T $current
                     *
                     * @return list<T>
                     */
                    static fn (array $stack, mixed $current): array => array_slice([...$stack, $current], ++$size * -1),
                    []
                ), 1);
    }
}

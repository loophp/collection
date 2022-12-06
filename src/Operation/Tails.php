<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\ConcatIterableAggregate;
use loophp\iterators\ReductionIterableAggregate;

use function array_slice;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Tails extends AbstractOperation
{
    /**
     * @return Closure(iterable<array-key, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<array-key, T> $iterable
             *
             * @return Generator<int, list<T>>
             */
            static function (iterable $iterable): Generator {
                $iterator = new ConcatIterableAggregate([
                    [0 => 0],
                    $iterable,
                ]);

                /** @var array<array-key, T> $generator */
                $generator = iterator_to_array((new Normalize())()($iterator));

                yield from new ReductionIterableAggregate(
                    $generator,
                    /**
                     * @param list<T> $stack
                     *
                     * @return list<T>
                     */
                    static fn (array $stack): array => array_slice($stack, 1),
                    $generator
                );
            };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;

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
     * @return Closure(iterable<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<int, list<T>>
             */
            static function (iterable $iterable): Generator {
                $initial = iterator_to_array(
                    (new IterableIteratorAggregate($iterable))->getIterator()
                );

                $reduction =
                    /**
                     * @param list<T> $stack
                     *
                     * @return list<T>
                     */
                    static fn (array $stack): array => array_slice($stack, 1);

                /** @var Closure(iterable<TKey, T>): Generator<int, list<T>> $pipe */
                $pipe = (new Pipe())()(
                    (new Reduction())()($reduction)($initial),
                    (new Normalize())(),
                );

                yield from $pipe($iterable);
            };
    }
}

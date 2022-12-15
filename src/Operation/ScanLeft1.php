<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class ScanLeft1 extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable((T|V), T, TKey, iterable<TKey, T>): (T|V)): Closure(iterable<TKey, T>): Generator<TKey, T|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((T|V), T, TKey, iterable<TKey, T>): (T|V) $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T|V>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, T|V>
                 */
                static function (iterable $iterable) use ($callback): Generator {
                    $iteratorAggregate = new IterableIteratorAggregate($iterable);

                    $iteratorInitial = $iteratorAggregate->getIterator();

                    if (false === $iteratorInitial->valid()) {
                        return;
                    }

                    $initial = $iteratorInitial->current();

                    /** @var Closure(iterable<TKey, T>): Generator<TKey, T|V> $pipe */
                    $pipe = (new Pipe())()(
                        (new Tail())(),
                        (new Reduction())()($callback)($initial),
                        (new Prepend())()([$initial])
                    );

                    yield from $pipe($iteratorAggregate);
                };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Iterator\IterableIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Unwindow extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, list<T>>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, list<T>>): Generator<TKey, T> $unwindow */
        $unwindow = Map::of()(
            /**
             * @psalm-param iterable<TKey, list<T>> $value
             */
            static fn (iterable $iterable): Iterator => new IterableIterator($iterable),
            /**
             * @psalm-param Iterator<TKey, list<T>> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                /** @psalm-var Closure(Iterator<TKey, list<T>>): Generator<TKey, T> $last */
                $last = Last::of();

                return $last($iterator);
            },
            /**
             * @psalm-param Generator<TKey, T> $value
             *
             * @psalm-return T
             */
            static fn (Generator $value) => $value->current()
        );

        // Point free style.
        return $unwindow;
    }
}

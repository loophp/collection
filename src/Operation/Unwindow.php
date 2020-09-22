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
        /** @psalm-var Closure(Iterator<TKey, list<T>>): Generator<TKey, T> $compose */
        $compose = Compose::of()(
            Map::of()(
                /**
                 * @psalm-param iterable<TKey, list<T>> $value
                 */
                static function (iterable $iterable): IterableIterator {
                    return new IterableIterator($iterable);
                }
            ),
            Map::of()(
                /**
                 * @psalm-param IterableIterator<TKey, list<T>> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (IterableIterator $iterator): Iterator {
                    /** @psalm-var Closure(IterableIterator<TKey, list<T>>): Generator<TKey, T> $last */
                    $last = Last::of();

                    return $last($iterator);
                }
            ),
            Map::of()(
                /**
                 * @psalm-param Generator<TKey, T> $value
                 *
                 * @psalm-return T
                 */
                static function (Generator $value) {
                    return $value->current();
                }
            )
        );

        // Point free style.
        return $compose;
    }
}

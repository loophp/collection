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
 *
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Unpack extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<T, T, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<int, array{0:TKey, 1:T}> $iterator
             *
             * @psalm-return Generator<T, T, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                $isIterable =
                    /**
                     * @psalm-param T $value
                     *
                     * @param mixed $value
                     */
                    static function ($value): bool {
                        return is_iterable($value);
                    };

                $toIterableIterator = static function (iterable $value): IterableIterator {
                    return new IterableIterator($value);
                };

                /** @psalm-var callable(Iterator<TKey, T|iterable<TKey, T>>): Generator<TKey, iterable<TKey, T>> $filter */
                $filter = Filter::of()($isIterable);

                /** @psalm-var callable(Iterator<TKey, iterable<TKey, T>>): Generator<TKey, Iterator<TKey, T>> $map */
                $map = Map::of()($toIterableIterator);

                /** @psalm-var IterableIterator<int, array{0:TKey, 1:T}> $value */
                foreach (Compose::of()($filter, $map)($iterator) as $value) {
                    /** @psalm-var array<int, array<T, T>> $chunks */
                    $chunks = Chunk::of()(2)($value);

                    foreach ($chunks as [$k, $v]) {
                        yield $k => $v;
                    }
                }
            };
    }
}

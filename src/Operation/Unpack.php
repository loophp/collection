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
final class Unpack extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<int, array{0: TKey, 1: T}>): Generator<T, T>
     */
    public function __invoke(): Closure
    {
        $toIterableIterator = static fn (iterable $value): Iterator => new IterableIterator($value);

        $callbackForKeys =
            /**
             * @param mixed $initial
             * @psalm-param T $initial
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return TKey
             */
            static fn ($initial, int $key, array $value) => $value[0];

        $callbackForValues =
            /**
             * @param mixed $initial
             * @psalm-param T $initial
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return T
             */
            static fn ($initial, int $key, array $value) => $value[1];

        /** @psalm-var Closure(Iterator<int, array{0: TKey, 1: T}>): Generator<T, T> $pipe */
        $pipe = Pipe::of()(
            Map::of()($toIterableIterator, Chunk::of()(2)),
            Unwrap::of(),
            Associate::of()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}

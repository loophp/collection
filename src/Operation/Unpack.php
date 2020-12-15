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
     * @psalm-return Closure(Iterator<int, array{0: TKey, 1: T}>): Generator<T, T>
     */
    public function __invoke(): Closure
    {
        $isIterable =
            /**
             * @psalm-param T $value
             *
             * @param mixed $value
             */
            static fn ($value): bool => is_iterable($value);

        $toIterableIterator = static fn (iterable $value): IterableIterator => new IterableIterator($value);

        $callbackForKeys =
            /**
             * @psalm-param T $initial
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return TKey
             *
             * @param mixed $initial
             */
            static fn ($initial, int $key, array $value) => $value[0];

        $callbackForValues =
            /**
             * @psalm-param T $initial
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return T
             *
             * @param mixed $initial
             */
            static fn ($initial, int $key, array $value) => $value[1];

        /** @psalm-var Closure(Iterator<int, array{0: TKey, 1: T}>): Generator<T, T> $pipe */
        $pipe = Pipe::of()(
            Filter::of()($isIterable),
            Map::of()($toIterableIterator, Chunk::of()(2)),
            Unwrap::of(),
            Associate::of()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}

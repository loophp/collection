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
            static function ($value): bool {
                return is_iterable($value);
            };

        $toIterableIterator = static function (iterable $value): IterableIterator {
            return new IterableIterator($value);
        };

        $callbackForKeys =
            /**
             * @psalm-param T $initial
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return TKey
             *
             * @param mixed $initial
             */
            static function ($initial, int $key, array $value) {
                return $value[0];
            };

        $callbackForValues =
            /**
             * @psalm-param T $initial
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return T
             *
             * @param mixed $initial
             */
            static function ($initial, int $key, array $value) {
                return $value[1];
            };

        /** @psalm-var Closure(Iterator<int, array{0: TKey, 1: T}>): Generator<T, T> $pipe */
        $pipe = Pipe::of()(
            Filter::of()($isIterable),
            Map::of()($toIterableIterator),
            Map::of()(Chunk::of()(2)),
            Unwrap::of(),
            Associate::of()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}

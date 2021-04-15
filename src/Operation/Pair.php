<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Pair extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<T|TKey, T>
     */
    public function __invoke(): Closure
    {
        $callbackForKeys =
            /**
             * @psalm-param T $initial
             * @psalm-param TKey $key
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return TKey|T
             *
             * @param mixed $initial
             * @param mixed $key
             */
            static fn ($initial, $key, array $value) => $value[0];

        $callbackForValues =
            /**
             * @psalm-param T $initial
             * @psalm-param TKey $key
             * @psalm-param array{0: TKey, 1: T} $value
             *
             * @psalm-return T|TKey
             *
             * @param mixed $initial
             * @param mixed $key
             */
            static fn ($initial, $key, array $value) => $value[1];

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<T|TKey, T> $pipe */
        $pipe = Pipe::of()(
            Chunk::of()(2),
            Map::of()(
                static fn (array $value): array => array_values($value)
            ),
            Associate::of()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}

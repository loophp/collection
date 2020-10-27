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
final class Pack extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @psalm-param T $value
             * @psalm-param TKey $key
             *
             * @param mixed $value
             * @param mixed $key
             *
             * @psalm-return array{0: TKey, 1: T}
             */
            static fn ($value, $key): array => [$key, $value];

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}> $pipe */
        $pipe = Pipe::of()(
            Map::of()($mapCallback),
            Normalize::of()
        );

        // Point free style.
        return $pipe;
    }
}

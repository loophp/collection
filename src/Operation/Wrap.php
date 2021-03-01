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
final class Wrap extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, array<TKey, T>>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @param mixed $value
             * @param mixed $key
             *
             * @psalm-param T $value
             * @psalm-param TKey $key
             *
             * @psalm-return array<TKey, T>
             */
            static fn ($value, $key): array => [$key => $value];

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, array<TKey, T>> $pipe */
        $pipe = Pipe::of()(
            Map::of()($mapCallback),
            Normalize::of()
        );

        // Point free style.
        return $pipe;
    }
}

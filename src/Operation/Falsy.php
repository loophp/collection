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
final class Falsy extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        $matchCallback =
            /**
             * @param mixed $value
             * @psalm-param T $value
             */
            static fn ($value): bool => (bool) $value;

        $mapCallback =
            /**
             * @param mixed $value
             * @psalm-param T $value
             */
            static fn ($value): bool => !(bool) $value;

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
        $pipe = Pipe::of()(
            Match::of()(static fn () => true)($matchCallback),
            Map::of()($mapCallback),
        );

        // Point free style.
        return $pipe;
    }
}

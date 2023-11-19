<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Entropy extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, int<0,1>|float>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<int, int<0,1>|float> $pipe */
        $pipe = (new Pipe())()(
            (
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return CollectionInterface<int, T>
                 */
                static fn (iterable $iterable): CollectionInterface => Collection::fromIterable($iterable)->normalize()->squash()
            ),
            (new Map())()(
                /**
                 * @param T $_
                 * @param int $key
                 * @param Collection<TKey, T> $collection
                 */
                static fn (mixed $_, int $key, Collection $collection): float => $collection
                    ->limit($key + 1)
                    ->frequency()
                    ->map(
                        /**
                         * @param T $_
                         */
                        static fn (mixed $_, int $freq): float => $freq / ($key + 1)
                    )
                    ->reduce(
                        static fn (float $acc, float $p, int $_, Collection $c): float => 0 === $key ? $acc : $acc - $p * log($p, 2) / log($c->count(), 2),
                        0
                    )
            ),
            (new Map())()(
                /**
                 * @return int<0,1>|float
                 */
                static fn (float $value): float|int => (0.0 === $value || 1.0 === $value) ? (int) $value : $value
            )
        );

        // Point free style
        return $pipe;
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Collection;

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
            (new Map())()(
                /**
                 * @param T $_
                 * @param iterable<TKey, T> $iterable
                 */
                static function (mixed $_, int $key, iterable $iterable): float {
                    $collection = Collection::fromIterable($iterable);

                    return $collection
                        ->normalize()
                        ->squash()
                        ->limit($key + 1)
                        ->frequency()
                        ->map(
                            /**
                             * @param T $_
                             */
                            static fn (mixed $_, int $freq): float => $freq / ($key + 1)
                        )
                        ->reduce(
                            static fn (float $acc, float $p, int $k): float => 0 === $key ? $acc : $acc - $p * log($p, 2) / ((1 === $k) ? 1 : log($k, 2)),
                            0
                        );
                }
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

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Dispersion extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, float|int<0,1>>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<int, float|int<0,1>> $pipe */
        $pipe = (new Pipe())()(
            (new Normalize())(),
            (new ScanLeft())()(
                /**
                 * @param array<numeric-string|int<0,1>, T> $acc
                 * @param T $value
                 *
                 * @return list{float|int<0,1>, T}
                 */
                static function (array $acc, mixed $value, int $key): array {
                    [$c, $v] = $acc;

                    return [(0 === $key) ? 0 : (($c * ($key - 1) + (($v === $value) ? 0 : 1)) / $key), $value];
                }
            )([0, null]),
            (new Drop())()(1),
            (new Map())()(
                /**
                 * @param array<numeric-string|int<0,1>, T> $value
                 *
                 * @return float|int<0,1>
                 */
                static fn (array $value): float|int => (0.0 === $value[0] || 1.0 === $value[0]) ? (int) $value[0] : $value[0]
            )
        );

        return $pipe;
    }
}

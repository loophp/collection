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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Averages extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, float>
     */
    public function __invoke(): Closure
    {
        return (new Pipe())()(
            (new Normalize())(),
            (new ScanLeft1())()(
                static fn (float $acc, float $value, int $key): float => ($acc * $key + $value) / ($key + 1)
            )
        );
    }
}

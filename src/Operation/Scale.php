<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

use const INF;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Scale extends AbstractOperation implements Operation
{
    public function __construct(
        float $lowerBound,
        float $upperBound,
        float $wantedLowerBound = 0.0,
        float $wantedUpperBound = 1.0,
        float $base = 0.0
    ) {
        $wantedLowerBound = (0.0 === $wantedLowerBound) ? (0.0 === $base ? 0.0 : 1.0) : $wantedLowerBound; // phpcs:ignore
        $wantedUpperBound = (1.0 === $wantedUpperBound) ? (0.0 === $base ? 1.0 : $base) : $wantedUpperBound; // phpcs:ignore

        $this->storage['mapper'] = new Map(
            /**
             * @param float|int $v
             */
            static function ($v) use ($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound, $base): float { // phpcs:ignore
                $mx = 0.0 === $base ?
                    ($v - $lowerBound) / ($upperBound - $lowerBound) :
                    log($v - $lowerBound, $base) / log($upperBound - $lowerBound, $base);

                $mx = $mx === -INF ? 0 : $mx;

                return $wantedLowerBound + $mx * ($wantedUpperBound - $wantedLowerBound);
            }
        );

        $this->storage['filter'] = new Filter(
            /**
             * @param float|int $item
             */
            static function ($item) use ($lowerBound): bool {
                return $item >= $lowerBound;
            },
            /**
             * @param float|int $item
             */
            static function ($item) use ($upperBound): bool {
                return $item <= $upperBound;
            }
        );
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, Map $mapper, Filter $filter): Generator {
            return yield from (new Run($filter, $mapper))($iterator);
        };
    }
}

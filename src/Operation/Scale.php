<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Transformation\Run;

use const INF;

final class Scale extends AbstractOperation implements Operation
{
    public function __construct(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ) {
        $wantedLowerBound = $wantedLowerBound ?? (null === $base ? 0.0 : 1.0);
        $wantedUpperBound = $wantedUpperBound ?? ($base ?? 1.0);

        $this->storage['mapper'] = new Walk(
            /**
             * @param float|int $v
             */
            static function ($v) use ($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound, $base): float { // phpcs:ignore
                $mx = null === $base ?
                    ($v - $lowerBound) / ($upperBound - $lowerBound) :
                    log($v - $lowerBound, $base) / log($upperBound - $lowerBound, $base);

                if ($mx === -INF) {
                    $mx = 0;
                }

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
        return static function (iterable $collection, Walk $mapper, Filter $filter): ClosureIterator {
            return (new Run($filter, $mapper))($collection);
        };
    }
}

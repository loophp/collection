<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use loophp\collection\Contract\Operation;

use const INF;

/**
 * Class Scale.
 */
final class Scale implements Operation
{
    /**
     * @var \loophp\collection\Operation\Filter
     */
    private $filter;

    /**
     * @var \loophp\collection\Operation\Walk
     */
    private $mapper;

    /**
     * Scale constructor.
     *
     * @param float $lowerBound
     * @param float $upperBound
     * @param float|null $wantedLowerBound
     * @param float|null $wantedUpperBound
     * @param float|null $base
     */
    public function __construct(
        float $lowerBound,
        float $upperBound,
        ?float $wantedLowerBound = null,
        ?float $wantedUpperBound = null,
        ?float $base = null
    ) {
        if (null === $base) {
            $wantedLowerBound = $wantedLowerBound ?? 0.0;
            $wantedUpperBound = $wantedUpperBound ?? 1.0;
        } else {
            $wantedLowerBound = $wantedLowerBound ?? 1.0;
            $wantedUpperBound = $wantedUpperBound ?? $base;
        }

        $callback = static function ($v) use ($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound, $base): float { // phpcs:ignore
            if (null !== $base) {
                $mx = log($v - $lowerBound, $base) / log($upperBound - $lowerBound, $base);

                if ($mx === -INF) {
                    $mx = 0;
                }
            } else {
                $mx = ($v - $lowerBound) / ($upperBound - $lowerBound);
            }

            return $wantedLowerBound + $mx * ($wantedUpperBound - $wantedLowerBound);
        };

        $this->mapper = new Walk($callback);

        $this->filter = new Filter(
            static function ($item) use ($lowerBound): bool {
                return $item >= $lowerBound;
            },
            static function ($item) use ($upperBound): bool {
                return $item <= $upperBound;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        return $this->mapper->on($this->filter->on($collection)());
    }
}

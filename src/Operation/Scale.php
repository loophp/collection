<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use const INF;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Scale extends AbstractOperation implements Operation
{
    // phpcs:disable
    /**
     * @psalm-return Closure(float): Closure(float): Closure(float): Closure(float): Closure(float): Closure(Iterator<TKey, float|int>): Generator<TKey, float|int>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return static function (float $lowerBound): Closure {
            return static function (float $upperBound) use ($lowerBound): Closure {
                return static function (float $wantedLowerBound = 0.0) use ($lowerBound, $upperBound): Closure {
                    return static function (float $wantedUpperBound = 1.0) use ($lowerBound, $upperBound, $wantedLowerBound): Closure {  // phpcs:ignore
                        return static function (float $base = 0.0) use ($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound): Closure { // phpcs:ignore
                            return static function (Iterator $iterator) use ($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound, $base): Generator { // phpcs:ignore
                                $wantedLowerBound = (0.0 === $wantedLowerBound) ? (0.0 === $base ? 0.0 : 1.0) : $wantedLowerBound; // phpcs:ignore
                                $wantedUpperBound = (1.0 === $wantedUpperBound) ? (0.0 === $base ? 1.0 : $base) : $wantedUpperBound; // phpcs:ignore

                                /** @psalm-var callable(Generator<TKey, float|int>): Generator<TKey, float> $mapper */
                                $mapper = Map::of()(
                                    /**
                                     * @param mixed $v
                                     * @psalm-param float|int $v
                                     */
                                    static function ($v) use ($lowerBound, $upperBound, $wantedLowerBound, $wantedUpperBound, $base): float { // phpcs:ignore
                                        $mx = 0.0 === $base ?
                                            ($v - $lowerBound) / ($upperBound - $lowerBound) :
                                            log($v - $lowerBound, $base) / log($upperBound - $lowerBound, $base);

                                        $mx = $mx === -INF ? 0 : $mx;

                                        return $wantedLowerBound + $mx * ($wantedUpperBound - $wantedLowerBound);
                                    }
                                );

                                /** @psalm-var callable(Iterator<TKey, float|int>): Generator<TKey, float|int> $filter */
                                $filter = Filter::of()(
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

                                return yield from Compose::of()($filter, $mapper)($iterator);
                            };
                        };
                    };
                };
            };
        };
    }
}

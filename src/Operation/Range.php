<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use const INF;

final class Range extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (float $start = 0.0): Closure {
            return static function (float $end = INF) use ($start): Closure {
                return static function (float $step = 1.0) use ($start, $end): Closure {
                    return static function (Iterator $iterator) use ($start, $end, $step): Generator {
                        for ($current = $start; $current < $end; $current += $step) {
                            yield $current;
                        }
                    };
                };
            };
        };
    }
}

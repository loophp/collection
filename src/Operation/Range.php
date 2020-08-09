<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use const INF;

final class Range extends AbstractGeneratorOperation implements Operation
{
    public function __construct(float $start = 0.0, float $end = INF, float $step = 1.0)
    {
        $this->storage = [
            'start' => $start,
            'end' => $end,
            'step' => $step,
        ];
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, float $start, float $end, float $step): Generator {
            for ($current = $start; $current < $end; $current += $step) {
                yield $current;
            }
        };
    }
}

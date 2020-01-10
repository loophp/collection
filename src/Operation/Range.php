<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Range.
 */
final class Range implements Operation
{
    /**
     * @var float
     */
    private $end;

    /**
     * @var float
     */
    private $start;

    /**
     * @var float
     */
    private $step;

    /**
     * Range constructor.
     *
     * @param float $start
     * @param float $end
     * @param float $step
     */
    public function __construct(float $start = 0, float $end = INF, float $step = 1)
    {
        $this->start = $start;
        $this->end = $end;
        $this->step = $step;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $start = $this->start;
        $end = $this->end;
        $step = $this->step;

        return static function () use ($start, $end, $step): Generator {
            for ($current = $start; $current < $end; $current += $step) {
                yield $current;
            }
        };
    }
}

<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

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
    public function __construct(float $start, float $end, float $step)
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

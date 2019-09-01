<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Range.
 */
final class Range implements Operation
{
    /**
     * @var float|int
     */
    private $end;

    /**
     * @var int
     */
    private $start;

    /**
     * @var float
     */
    private $step;

    /**
     * Range constructor.
     *
     * @param int $start
     * @param float|int $end
     * @param float $step
     */
    public function __construct(int $start, $end, $step)
    {
        $this->start = $start;
        $this->end = $end;
        $this->step = $step;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $start = $this->start;
        $end = $this->end;
        $step = $this->step;

        return static function () use ($start, $end, $step) {
            for ($current = $start; $current < $end; $current += $step) {
                yield $current;
            }
        };
    }
}

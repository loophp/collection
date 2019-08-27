<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Range.
 */
final class Range extends Operation
{
    /**
     * Range constructor.
     *
     * @param int $start
     * @param float|int $end
     * @param float $step
     */
    public function __construct(int $start, $end, $step)
    {
        parent::__construct(...[$start, $end, $step]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$start, $end, $step] = $this->parameters;

        return static function () use ($start, $end, $step) {
            for ($current = $start; $current < $end; $current += $step) {
                yield $current;
            }
        };
    }
}

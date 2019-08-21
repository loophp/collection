<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Range.
 */
final class Range extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$start, $end, $step] = $this->parameters;

        return Collection::with(
            static function () use ($start, $end, $step) {
                for ($current = $start; $current < $end; $current += $step) {
                    yield $current;
                }
            }
        );
    }
}

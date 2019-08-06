<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Range.
 */
final class Range extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        [$start, $end, $step] = $this->parameters;

        return $collection::withClosure(
            static function () use ($start, $end, $step) {
                for ($current = $start; $current < $end; $current += $step) {
                    yield $current;
                }
            }
        );
    }
}

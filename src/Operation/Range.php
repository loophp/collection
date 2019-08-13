<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Range.
 */
final class Range extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$start, $end, $step] = $this->parameters;

        return Collection::withClosure(
            static function () use ($start, $end, $step) {
                for ($current = $start; $current < $end; $current += $step) {
                    yield $current;
                }
            }
        );
    }
}

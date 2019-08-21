<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Rebase.
 */
final class Rebase extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        return Collection::with($collection->getIterator());
    }
}

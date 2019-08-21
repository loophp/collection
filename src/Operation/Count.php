<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Count.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Count extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection)
    {
        return \iterator_count($collection->getIterator());
    }
}

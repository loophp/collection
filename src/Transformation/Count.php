<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;
use drupol\collection\Iterator\IterableIterator;

/**
 * Class Count.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Count implements Transformation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        return iterator_count(new IterableIterator($collection));
    }
}

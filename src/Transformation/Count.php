<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\IterableIterator;

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

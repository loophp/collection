<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\IterableIterator;

final class Count implements Transformation
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $collection)
    {
        return iterator_count(new IterableIterator($collection));
    }
}

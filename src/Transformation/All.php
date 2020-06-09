<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\IterableIterator;

/**
 * Class All.
 */
final class All implements Transformation
{
    /**
     * {@inheritdoc}
     *
     * @return mixed[]
     */
    public function __invoke(iterable $collection): array
    {
        return iterator_to_array(new IterableIterator($collection));
    }
}

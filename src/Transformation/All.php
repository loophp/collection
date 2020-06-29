<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\IterableIterator;

final class All implements Transformation
{
    /**
     * {@inheritdoc}
     *
     * @return array<mixed>
     */
    public function __invoke(iterable $collection): array
    {
        return iterator_to_array(new IterableIterator($collection));
    }
}

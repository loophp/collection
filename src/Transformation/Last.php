<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;
use drupol\collection\Iterator\ClosureIterator;
use Generator;

/**
 * Class Last.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Last implements Transformation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $value = null;

        foreach ($collection as $key => $value) {

        }

        return $value;
    }
}

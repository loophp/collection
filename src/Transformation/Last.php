<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

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
    public function __invoke(iterable $collection)
    {
        return (
        new FoldLeft(
            static function ($carry, $item) {
                return $item;
            }
        )
        )($collection);
    }
}

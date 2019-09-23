<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;
use drupol\collection\Iterator\ClosureIterator;

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
        $iterator = new ClosureIterator(
            static function () use ($collection) {
                foreach ($collection as $key => $value) {
                    yield $key => $value;
                }
            }
        );

        $reduced = new Reduce(
            static function ($carry, $item) {
                return $item;
            },
            $iterator->current()
        );

        return $reduced->on($collection);
    }
}

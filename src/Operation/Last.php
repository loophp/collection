<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Last.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Last extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection)
    {
        $iterator = new ClosureIterator(
            static function () use ($collection) {
                foreach ($collection as $k => $v) {
                    yield $k => $v;
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

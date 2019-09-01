<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Last.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Last implements Operation
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

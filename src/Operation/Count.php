<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Count.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Count extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        return \iterator_count(
            new ClosureIterator(
                static function () use ($collection) {
                    foreach ($collection as $key => $item) {
                        yield $key => $item;
                    }
                }
            )
        );
    }
}

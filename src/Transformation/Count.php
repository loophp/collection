<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformer;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Count.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Count implements Transformer
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        return \iterator_count(
            new ClosureIterator(
                static function () use ($collection) {
                    foreach ($collection as $key => $value) {
                        yield $key => $value;
                    }
                }
            )
        );
    }
}

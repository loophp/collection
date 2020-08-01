<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\IterableIterator;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements Transformation<TKey, T>
 */
final class Count implements Transformation
{
    public function __invoke(Iterator $collection)
    {
        return iterator_count(new IterableIterator($collection));
    }
}

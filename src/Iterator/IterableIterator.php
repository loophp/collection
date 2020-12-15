<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use ArrayIterator;
use IteratorIterator;

use function is_array;

/**
 * @psalm-template TKey
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class IterableIterator extends ProxyIterator
{
    /**
     * @param iterable<mixed> $iterable
     * @psalm-param iterable<TKey, T> $iterable
     */
    public function __construct(iterable $iterable)
    {
        if (is_array($iterable)) {
            $iterable = new ArrayIterator($iterable);
        }

        $this->iterator = new IteratorIterator($iterable);

        $this->rewind();
    }
}

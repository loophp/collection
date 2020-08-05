<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use ArrayIterator;
use IteratorAggregate;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements IteratorAggregate<ArrayIterator<TKey, T>>
 */
final class SortableIterableIterator implements IteratorAggregate
{
    /**
     * @var callable
     * @psalm-var callable(T, T):(int) $callable
     */
    private $callable;

    /**
     * @var \loophp\collection\Iterator\IterableIterator
     * @psalm-var \loophp\collection\Iterator\IterableIterator<TKey, T>
     */
    private $iterator;

    /**
     * @param iterable<mixed> $iterable
     * @psalm-param iterable<TKey, T> $iterable
     * @psalm-param callable(T, T):(int) $callable
     */
    public function __construct(iterable $iterable, callable $callable)
    {
        $this->callable = $callable;
        $this->iterator = new IterableIterator($iterable);
    }

    /**
     * {@inheritdoc}
     *
     * @psalm-return \ArrayIterator<TKey, T>
     */
    public function getIterator()
    {
        $arrayIterator = new ArrayIterator(iterator_to_array($this->iterator));

        $arrayIterator->uasort($this->callable);

        return $arrayIterator;
    }
}

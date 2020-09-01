<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use ArrayIterator;
use Iterator;
use OuterIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T of string
 *
 * @implements Iterator<TKey, T>
 */
final class RandomIterator implements Iterator, OuterIterator
{
    /**
     * @var array<int, int>
     */
    private $indexes;

    /**
     * @var Iterator
     * @psalm-var Iterator<TKey, T>
     */
    private $inner;

    /**
     * @var ArrayIterator
     * @psalm-var ArrayIterator<int, array{0: TKey, 1: T}>
     */
    private $iterator;

    /**
     * @var int
     */
    private $key;

    /**
     * @psalm-param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->inner = $iterator;
        $this->iterator = $this->buildArrayIterator($iterator);
        $this->indexes = array_keys($this->iterator->getArrayCopy());
        $this->key = array_rand($this->indexes);
    }

    public function current()
    {
        $value = $this->iterator[$this->key];

        return $value[1];
    }

    public function getInnerIterator()
    {
        return $this->inner;
    }

    public function key()
    {
        $value = $this->iterator[$this->key];

        return $value[0];
    }

    public function next(): void
    {
        unset($this->indexes[$this->key]);

        if ($this->valid()) {
            $this->key = array_rand($this->indexes);
        }
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    public function valid(): bool
    {
        return [] !== $this->indexes;
    }

    /**
     * @psalm-param Iterator<TKey, T> $iterator
     *
     * @psalm-return ArrayIterator<int, array{0: TKey, 1: T}>
     */
    private function buildArrayIterator(Iterator $iterator): ArrayIterator
    {
        /** @psalm-var ArrayIterator<int, array{0: TKey, 1: T}> $arrayIterator */
        $arrayIterator = new ArrayIterator();

        foreach ($iterator as $key => $value) {
            $arrayIterator->append([$key, $value]);
        }

        return $arrayIterator;
    }
}

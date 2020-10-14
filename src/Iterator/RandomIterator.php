<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use ArrayIterator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T of string
 *
 * @extends ProxyIterator<TKey, T>
 */
final class RandomIterator extends ProxyIterator
{
    /**
     * @psalm-var Iterator<TKey, T>
     */
    protected Iterator $iterator;

    /**
     * @var array<int, int>
     */
    private array $indexes;

    private int $key;

    /**
     * @psalm-var ArrayIterator<int, array{0: TKey, 1: T}>
     */
    private ArrayIterator $wrappedIterator;

    /**
     * @psalm-param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
        $this->wrappedIterator = $this->buildArrayIterator($iterator);
        $this->indexes = array_keys($this->wrappedIterator->getArrayCopy());
        $this->key = array_rand($this->indexes);
    }

    public function current()
    {
        $value = $this->wrappedIterator[$this->key];

        return $value[1];
    }

    public function key()
    {
        $value = $this->wrappedIterator[$this->key];

        return $value[0];
    }

    public function next(): void
    {
        unset($this->indexes[$this->key]);

        if ($this->valid()) {
            $this->key = array_rand($this->indexes);
        }
    }

    public function rewind(): void
    {
        parent::rewind();
        $this->indexes = array_keys($this->wrappedIterator->getArrayCopy());
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

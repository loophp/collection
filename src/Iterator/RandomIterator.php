<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use ArrayIterator;
use Iterator;
use OuterIterator;

use function array_slice;

use const PHP_INT_MAX;
use const PHP_INT_MIN;

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
    private array $indexes;

    /**
     * @psalm-var Iterator<TKey, T>
     */
    private Iterator $iterator;

    private int $key;

    private int $seed;

    /**
     * @psalm-var ArrayIterator<int, array{0: TKey, 1: T}>
     */
    private ArrayIterator $wrappedIterator;

    /**
     * @psalm-param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator, ?int $seed = null)
    {
        $this->iterator = $iterator;
        $this->seed = $seed ?? random_int(PHP_INT_MIN, PHP_INT_MAX);
        $this->wrappedIterator = $this->buildArrayIterator($iterator);
        $this->indexes = array_keys($this->wrappedIterator->getArrayCopy());
        $this->key = current($this->customArrayRand($this->indexes, 1, $this->seed));
    }

    public function current()
    {
        $value = $this->wrappedIterator[$this->key];

        return $value[1];
    }

    public function getInnerIterator()
    {
        return $this->iterator;
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
            $this->key = current($this->customArrayRand($this->indexes, 1, $this->seed));
        }
    }

    public function rewind(): void
    {
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

    private function customArrayRand(array $array, int $num, int $seed): array
    {
        mt_srand($seed);
        shuffle($array);
        mt_srand();

        return array_slice($array, 0, $num);
    }
}

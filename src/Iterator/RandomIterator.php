<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use BadMethodCallException;
use Iterator;
use ReturnTypeWillChange;

use function assert;

use const PHP_INT_MAX;
use const PHP_INT_MIN;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class RandomIterator extends ProxyIterator
{
    /**
     * @var array<int, int>
     */
    private array $indexes = [];

    private ?int $key = 0;

    private int $seed;

    /**
     * @var Iterator<TKey, T>
     */
    private Iterator $wrappedIterator;

    /**
     * @param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator, ?int $seed = null)
    {
        $this->iterator = $iterator;
        $this->seed = $seed ?? random_int(PHP_INT_MIN, PHP_INT_MAX);
        $this->wrappedIterator = new ArrayCacheIterator($iterator);
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        if (!$this->valid()) {
            throw new BadMethodCallException("Cannot call 'current()' on invalid RandomIterator.");
        }

        assert(null !== $this->key);

        $keyValueTuple = $this->getNextItemAtKey($this->key);

        return $keyValueTuple[1];
    }

    #[ReturnTypeWillChange]
    public function key()
    {
        if (!$this->valid()) {
            throw new BadMethodCallException("Cannot call 'key()' on invalid RandomIterator.");
        }

        assert(null !== $this->key);

        $keyValueTuple = $this->getNextItemAtKey($this->key);

        return $keyValueTuple[0];
    }

    public function next(): void
    {
        if (null !== $this->key) {
            unset($this->indexes[$this->key]);
            $this->key = key($this->indexes);
        }
    }

    public function rewind(): void
    {
        // @todo: Try to get rid of iterator_count().
        $this->indexes = $this->predictableRandomArray(
            range(0, iterator_count($this->wrappedIterator) - 1),
            $this->seed
        );
        $this->key = 0;
    }

    public function valid(): bool
    {
        return [] !== $this->indexes && null !== $this->key;
    }

    /**
     * We do not cache the values in here.
     * It's already done in the ArrayCacheIterator.
     *
     * @return array{0: TKey, 1: T}
     */
    private function getNextItemAtKey(int $key): array
    {
        $i = 0;

        $this->wrappedIterator->rewind();

        while ($this->indexes[$key] !== $i++) {
            $this->wrappedIterator->next();
        }

        return [$this->wrappedIterator->key(), $this->wrappedIterator->current()];
    }

    /**
     * @param array<int, int> $array
     *
     * @return array<int, int>
     */
    private function predictableRandomArray(array $array, int $seed): array
    {
        mt_srand($seed);
        shuffle($array);
        mt_srand();

        return $array;
    }
}

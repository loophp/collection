<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Iterator;

use function array_key_exists;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @implements Iterator<TKey, T>
 */
final class ArrayCacheIterator implements Iterator
{
    /**
     * @var array<int, array{0: TKey, 1: T}>
     */
    private array $cache = [];

    /**
     * @var Iterator<TKey, T>
     */
    private Iterator $iterator;

    private int $key = 0;

    /**
     * @param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @return T
     */
    public function current()
    {
        $data = $this->getTupleFromCache($this->key);

        return $data[1];
    }

    /**
     * @return TKey
     */
    public function key()
    {
        $data = $this->getTupleFromCache($this->key);

        return $data[0];
    }

    public function next(): void
    {
        // This is mostly for iterator_count().
        $this->getTupleFromCache($this->key++);

        $this->iterator->next();
    }

    public function rewind(): void
    {
        // No call to $this->iterator->rewind() because we do not know if the inner
        // iterator can be rewinded or not.
        $this->key = 0;
    }

    public function valid(): bool
    {
        return $this->iterator->valid() || array_key_exists($this->key, $this->cache);
    }

    /**
     * @return array{0: TKey, 1: T}
     */
    private function getTupleFromCache(int $key): array
    {
        return $this->cache[$key] ??= [
            $this->iterator->key(),
            $this->iterator->current(),
        ];
    }
}

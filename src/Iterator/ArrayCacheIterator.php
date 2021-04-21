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
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class ArrayCacheIterator extends ProxyIterator
{
    /**
     * @psalm-var array<int, array{0: TKey, 1: T}>
     */
    private array $cache = [];

    private int $key = 0;

    /**
     * @psalm-param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @psalm-return T
     */
    public function current()
    {
        $data = $this->getTupleFromCache($this->key);

        return $data[1];
    }

    /**
     * @psalm-return TKey
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

        parent::next();
    }

    public function rewind(): void
    {
        // No call to parent::rewind() because we do not know if the inner
        // iterator can be rewinded or not.
        $this->key = 0;
    }

    public function valid(): bool
    {
        return parent::valid() || array_key_exists($this->key, $this->cache);
    }

    /**
     * @psalm-return array{0: TKey, 1: T}
     */
    private function getTupleFromCache(int $key): array
    {
        return $this->cache[$key] ??= [
            parent::key(),
            parent::current(),
        ];
    }
}

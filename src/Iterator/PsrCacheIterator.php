<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Iterator;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @internal
 *
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class PsrCacheIterator extends ProxyIterator
{
    private CacheItemPoolInterface $cache;

    private int $key = 0;

    /**
     * @psalm-param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator, CacheItemPoolInterface $cache)
    {
        $this->iterator = $iterator;
        $this->cache = $cache;
    }

    /**
     * @psalm-return T
     */
    public function current()
    {
        /** @psalm-var array{TKey, T} $data */
        $data = $this->getTupleFromCache($this->key)->get();

        return $data[1];
    }

    /**
     * @psalm-return TKey
     */
    public function key()
    {
        /** @psalm-var array{TKey, T} $data */
        $data = $this->getTupleFromCache($this->key)->get();

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
        return parent::valid() || $this->cache->hasItem((string) $this->key);
    }

    private function getTupleFromCache(int $key): CacheItemInterface
    {
        $item = $this->cache->getItem((string) $key);

        if (false === $item->isHit()) {
            $item->set([
                parent::key(),
                parent::current(),
            ]);

            $this->cache->save($item);
        }

        return $item;
    }
}

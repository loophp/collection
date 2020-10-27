<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Iterator;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class CacheIterator extends ProxyIterator
{
    private CacheItemPoolInterface $cache;

    private int $key;

    /**
     * @psalm-param Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator, CacheItemPoolInterface $cache)
    {
        $this->iterator = $iterator;
        $this->cache = $cache;
        $this->key = 0;
    }

    /**
     * @psalm-return T
     */
    public function current()
    {
        /** @psalm-var array{TKey, T} $data */
        $data = $this->getItemOrSave((string) $this->key)->get();

        return $data[1];
    }

    /**
     * @psalm-return TKey
     */
    public function key()
    {
        /** @psalm-var array{TKey, T} $data */
        $data = $this->getItemOrSave((string) $this->key)->get();

        return $data[0];
    }

    public function next(): void
    {
        ++$this->key;
        parent::next();
    }

    public function rewind(): void
    {
        $this->key = 0;
    }

    public function valid(): bool
    {
        return $this->cache->hasItem((string) $this->key) || parent::valid();
    }

    private function getItemOrSave(string $key): CacheItemInterface
    {
        $item = $this->cache->getItem($key);

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

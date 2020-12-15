<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Iterator;
use IteratorIterator;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @extends IteratorIterator<TKey, T>
 */
final class CacheIterator extends ProxyIterator
{
    private CacheItemPoolInterface $cache;

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
        $data = $this->getItemOrSave((string) $this->iterator->key())->get();

        return $data[1];
    }

    /**
     * @psalm-return TKey
     */
    public function key()
    {
        /** @psalm-var array{TKey, T} $data */
        $data = $this->getItemOrSave((string) $this->iterator->key())->get();

        return $data[0];
    }

    public function valid(): bool
    {
        $key = (string) $this->iterator->key();

        return '' !== $key && ($this->iterator->valid() || $this->cache->hasItem($key));
    }

    private function getItemOrSave(string $key): CacheItemInterface
    {
        $item = $this->cache->getItem($key);

        if (false === $item->isHit()) {
            $item->set([
                $this->iterator->key(),
                $this->iterator->current(),
            ]);

            $this->cache->save($item);
        }

        return $item;
    }
}

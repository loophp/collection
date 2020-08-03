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
 * @implements \Iterator<TKey, T>
 */
final class CacheIterator implements Iterator
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var Iterator
     * @psalm-var Iterator<TKey, T>
     */
    private $inner;

    /**
     * @var int
     */
    private $key;

    /**
     * @psalm-param \Iterator<TKey, T> $iterator
     */
    public function __construct(Iterator $iterator, CacheItemPoolInterface $cache)
    {
        $this->inner = $iterator;
        $this->cache = $cache;
        $this->key = 0;
    }

    /**
     * @psalm-return T
     */
    public function current()
    {
        return $this->getItemOrSave((string) $this->key)->get()[1];
    }

    /**
     * @psalm-return TKey
     */
    public function key()
    {
        return $this->getItemOrSave((string) $this->key)->get()[0];
    }

    public function next(): void
    {
        ++$this->key;
        $this->inner->next();
    }

    public function rewind(): void
    {
        $this->key = 0;
    }

    public function valid(): bool
    {
        return $this->cache->hasItem((string) $this->key) || $this->inner->valid();
    }

    private function getItemOrSave(string $key): CacheItemInterface
    {
        $item = $this->cache->getItem($key);

        if (false === $item->isHit()) {
            $item->set([
                $this->inner->key(),
                $this->inner->current(),
            ]);

            $this->cache->save($item);
        }

        return $item;
    }
}

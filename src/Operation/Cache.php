<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Iterator\PsrCacheIterator;
use loophp\iterators\IterableIteratorAggregate;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Cache extends AbstractOperation
{
    /**
     * @return Closure(CacheItemPoolInterface): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (CacheItemPoolInterface $cache): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, T>
                 */
                static fn (iterable $iterable): Generator => yield from new PsrCacheIterator((new IterableIteratorAggregate($iterable))->getIterator(), $cache);
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Iterator\CacheIterator;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Cache extends AbstractOperation
{
    /**
     * @psalm-return Closure(CacheItemPoolInterface): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return static function (CacheItemPoolInterface $cache): Closure {
            return
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($cache): Generator {
                    return yield from new CacheIterator($iterator, $cache);
                };
        };
    }
}

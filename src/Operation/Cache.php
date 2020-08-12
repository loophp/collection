<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;
use loophp\collection\Iterator\CacheIterator;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Cache extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(?CacheItemPoolInterface $cache = null)
    {
        $this->storage['cache'] = $cache ?? new ArrayAdapter();
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, CacheItemPoolInterface $cache): Generator {
                return yield from new CacheIterator($iterator, $cache);
            };
    }
}

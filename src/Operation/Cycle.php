<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use loophp\iterators\InfiniteIteratorAggregate;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Cycle extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): iterable<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return iterable<TKey, T>
             */
            static function (iterable $iterable): iterable {
                yield from new InfiniteIteratorAggregate((new IterableIteratorAggregate($iterable))->getIterator());
            };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\CachingIteratorAggregate;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Memorize extends AbstractOperation
{
    /**
     *
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<TKey, T>
             */
            static function (iterable $iterable): Generator {
                yield from (new CachingIteratorAggregate((new IterableIteratorAggregate($iterable))->getIterator()));
            };
    }
}

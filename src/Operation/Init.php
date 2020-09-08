<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CachingIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Init extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                $cacheIterator = new CachingIterator($iterator);
                $cacheIterator->next();

                for (; $iterator->valid(); $cacheIterator->next()) {
                    /** @psalm-var TKey $key */
                    $key = $cacheIterator->key();
                    /** @psalm-var T $current */
                    $current = $cacheIterator->current();

                    yield $key => $current;
                }
            };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CachingIterator;
use Closure;
use EmptyIterator;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Last extends AbstractOperation
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
                if (!$iterator->valid()) {
                    return new EmptyIterator();
                }

                $cachingIterator = new CachingIterator($iterator, CachingIterator::FULL_CACHE);

                while ($iterator->valid()) {
                    $cachingIterator->next();
                }

                /** @psalm-var TKey $key */
                $key = $cachingIterator->key();
                /** @psalm-var T $current */
                $current = $cachingIterator->current();

                return yield $key => $current;
            };
    }
}

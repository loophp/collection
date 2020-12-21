<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Collapse extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<array-key, (T | iterable<TKey, T>)>):Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<array-key, T|iterable<TKey, T>> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                for (; $iterator->valid(); $iterator->next()) {
                    $current = $iterator->current();

                    if (false === is_iterable($current)) {
                        continue;
                    }

                    yield from $current;
                }
            };
    }
}

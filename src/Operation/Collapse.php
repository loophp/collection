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
                foreach ($iterator as $value) {
                    if (false === is_iterable($value)) {
                        continue;
                    }

                    /**
                     * @psalm-var TKey $subKey
                     * @psalm-var T $subValue
                     */
                    foreach ($value as $subKey => $subValue) {
                        yield $subKey => $subValue;
                    }
                }
            };
    }
}

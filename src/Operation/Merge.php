<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Merge extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(iterable<TKey, T>...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param iterable<TKey, T> ...$sources
             */
            static function (iterable ...$sources): Closure {
                return
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($sources): Generator {
                    foreach ($iterator as $key => $value) {
                        yield $key => $value;
                    }

                    foreach ($sources as $source) {
                        foreach ($source as $key => $value) {
                            yield $key => $value;
                        }
                    }
                };
            };
    }
}

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
final class Unwrap extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<array-key, array<TKey, T>>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<int, array<TKey, T>> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $value) {
                    foreach ((array) $value as $k => $v) {
                        yield $k => $v;
                    }
                }
            };
    }
}

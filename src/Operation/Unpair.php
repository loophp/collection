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
final class Unpair extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, array{TKey, T}>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<int, array{TKey, T}>
             */
            static function (Iterator $iterator): Generator {
                for (; $iterator->valid(); $iterator->next()) {
                    yield $iterator->key();

                    yield $iterator->current();
                }
            };
    }
}
